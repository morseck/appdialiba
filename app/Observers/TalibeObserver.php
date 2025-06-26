<?php

namespace App\Observers;

use App\Talibe;
use App\Events\TalibeCreated;
use App\Events\TalibeUpdated;
use App\Events\TalibeDaaraChanged;

class TalibeObserver
{
public function created(Talibe $talibe)
{
event(new TalibeCreated($talibe, auth()->user()));
}

public function updated(Talibe $talibe)
{
$changes = $talibe->getChanges();

// Vérifier si le daara a changé
if (isset($changes['daara_id'])) {
$oldDaara = \App\Daara::find($talibe->getOriginal('daara_id'));
$newDaara = $talibe->daara;
event(new TalibeDaaraChanged($talibe, $oldDaara, $newDaara, auth()->user()));
}

if (!empty($changes)) {
event(new TalibeUpdated($talibe, $changes, auth()->user()));
}
}
}
