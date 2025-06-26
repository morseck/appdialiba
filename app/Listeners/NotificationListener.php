<?php
namespace App\Listeners;

use App\Services\NotificationService;
use App\Events\TalibeCreated;
use App\Events\TalibeUpdated;
use App\Events\TalibeDaaraChanged;
use App\Events\TalibeHizibChanged;
use App\Events\DieuwCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationListener implements ShouldQueue
{
    use InteractsWithQueue;

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle TalibeCreated event
     */
    public function handleTalibeCreated(TalibeCreated $event)
    {
        $data = [
            'talibe_nom' => $event->talibe->fullname(),
            'talibe_age' => $event->talibe->age(),
            'daara_nom' => $event->talibe->daara->nom,
            'dieuw_nom' => $event->talibe->dieuw ? $event->talibe->dieuw->fullname() : 'Non assigné',
            'user_nom' => $event->user ? $event->user->name : 'Système',
            'date' => now()->format('d/m/Y H:i')
        ];

        $this->notificationService->trigger('talibe.created', $data, $event->talibe->daara);
    }

    /**
     * Handle TalibeUpdated event
     */
    public function handleTalibeUpdated(TalibeUpdated $event)
    {
        $data = [
            'talibe_nom' => $event->talibe->fullname(),
            'changes' => implode(', ', array_keys($event->changes)),
            'daara_nom' => $event->talibe->daara->nom,
            'user_nom' => $event->user ? $event->user->name : 'Système',
            'date' => now()->format('d/m/Y H:i')
        ];

        $this->notificationService->trigger('talibe.updated', $data, $event->talibe->daara);
    }

    /**
     * Handle TalibeDaaraChanged event
     */
    public function handleTalibeDaaraChanged(TalibeDaaraChanged $event)
    {
        $data = [
            'talibe_nom' => $event->talibe->fullname(),
            'ancien_daara' => $event->oldDaara ? $event->oldDaara->nom : 'Inconnu',
            'nouveau_daara' => $event->newDaara->nom,
            'user_nom' => $event->user ? $event->user->name : 'Système',
            'date' => now()->format('d/m/Y H:i')
        ];

        // Notifier l'ancien et le nouveau daara
        $this->notificationService->trigger('talibe.daara_changed', $data, $event->oldDaara);
        $this->notificationService->trigger('talibe.daara_changed', $data, $event->newDaara);
    }

    /**
     * Handle TalibeHizibChanged event
     */
    public function handleTalibeHizibChanged(TalibeHizibChanged $event)
    {
        $data = [
            'talibe_nom' => $event->talibe->fullname(),
            'ancien_hizib' => $event->oldHizib,
            'nouveau_hizib' => $event->newHizib,
            'daara_nom' => $event->talibe->daara->nom,
            'user_nom' => $event->user ? $event->user->name : 'Système',
            'date' => now()->format('d/m/Y H:i')
        ];

        $this->notificationService->trigger('talibe.hizib_changed', $data, $event->talibe->daara);
    }

    /**
     * Handle DieuwCreated event
     */
    public function handleDieuwCreated(DieuwCreated $event)
    {
        $data = [
            'dieuw_nom' => $event->dieuw->fullname(),
            'daara_nom' => $event->dieuw->daara->nom,
            'user_nom' => $event->user ? $event->user->name : 'Système',
            'date' => now()->format('d/m/Y H:i')
        ];

        $this->notificationService->trigger('dieuw.created', $data, $event->dieuw->daara);
    }

    /**
     * Register the listeners for the subscriber
     */
    public function subscribe($events)
    {
        $events->listen(
            TalibeCreated::class,
            'App\Listeners\NotificationListener@handleTalibeCreated'
        );

        $events->listen(
            TalibeUpdated::class,
            'App\Listeners\NotificationListener@handleTalibeUpdated'
        );

        $events->listen(
            TalibeDaaraChanged::class,
            'App\Listeners\NotificationListener@handleTalibeDaaraChanged'
        );

        $events->listen(
            TalibeHizibChanged::class,
            'App\Listeners\NotificationListener@handleTalibeHizibChanged'
        );

        $events->listen(
            DieuwCreated::class,
            'App\Listeners\NotificationListener@handleDieuwCreated'
        );
    }
}
