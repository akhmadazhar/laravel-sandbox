<?php

namespace App\Observers;

use App\Models\Pegawai;
use Illuminate\Support\Facades\Cache;

class PegawaiObserver
{
    /**
     * Handle the Pegawai "created" event.
     */
    public function created(Pegawai $pegawai): void
    {
        Cache::forget('pegawai-display');
    }

    /**
     * Handle the Pegawai "updated" event.
     */
    public function updated(Pegawai $pegawai): void
    {
        if(Cache::get('pegawai-display_'.$pegawai->id)){
            Cache::forget('pegawai-display_'.$pegawai->id);
        }
        Cache::forget('pegawai-display');
    }

    /**
     * Handle the Pegawai "deleted" event.
     */
    public function deleted(Pegawai $pegawai): void
    {
        if(Cache::get('pegawai-display_'.$pegawai->id)){
            Cache::forget('pegawai-display.'.$pegawai->id);
        }
        Cache::forever('pegawai-display');
    }

    /**
     * Handle the Pegawai "restored" event.
     */
    public function restored(Pegawai $pegawai): void
    {
        //
    }

    /**
     * Handle the Pegawai "force deleted" event.
     */
    public function forceDeleted(Pegawai $pegawai): void
    {
        //
    }
}
