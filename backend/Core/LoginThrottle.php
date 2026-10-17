<?php

/**
 * จำกัดจำนวนครั้งที่ล็อกอินผิดต่อ IP + ชื่อผู้ใช้ (เก็บเป็นไฟล์ใน storage/throttle)
 */
final class LoginThrottle
{
    private $file;
    private $maxAttempts;
    private $lockoutSeconds;

    public function __construct($username)
    {
        $key = hash('sha256', Request::ip() . '|' . mb_strtolower($username));
        $this->file = BASE_PATH . '/storage/throttle/' . $key . '.json';
        $this->maxAttempts = (int) Config::get('login.max_attempts', 5);
        $this->lockoutSeconds = (int) Config::get('login.lockout_seconds', 900);
    }

    /** จำนวนวินาทีที่ต้องรอ (0 = ล็อกอินได้) */
    public function secondsUntilUnlocked()
    {
        $state = $this->read();
        if ($state['attempts'] < $this->maxAttempts) {
            return 0;
        }
        return max(0, $state['first'] + $this->lockoutSeconds - time());
    }

    public function hit()
    {
        $state = $this->read();
        $state['attempts']++;
        file_put_contents($this->file, json_encode($state), LOCK_EX);
    }

    public function clear()
    {
        if (is_file($this->file)) {
            unlink($this->file);
        }
    }

    private function read()
    {
        $fresh = ['attempts' => 0, 'first' => time()];
        if (!is_file($this->file)) {
            return $fresh;
        }

        $state = json_decode((string) file_get_contents($this->file), true);
        if (!is_array($state) || time() - $state['first'] > $this->lockoutSeconds) {
            return $fresh;
        }
        return $state;
    }
}
