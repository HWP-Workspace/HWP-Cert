<?php

final class StatController
{
    public static function routes()
    {
        return [
            'counts' => ['GET', [self::class, 'counts']],
        ];
    }

    public static function counts()
    {
        Auth::authorize();
        Response::json([
            'ok'           => true,
            'projects'     => Project::count(),
            'participants' => Participant::count(),
            'admins'       => Admin::count(),
        ]);
    }
}
