<?php

namespace App;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait RecordsActivity{

    public $oldAttributes = [];

    // to run boot method in trait bootTraitName
    public static function bootRecordsActivity()
    {
        $recordableEvents = self::recordableEvents();

        foreach ($recordableEvents as $event) {
            static::$event(function($entity) use($event){
                $entity->recordActivity($entity->eventDescription($event));
            });
            if($event === 'updated'){
                static::updating(function($entity){
                    $entity->oldAttributes = $entity->getOriginal();
                });
            }
        }

    }

    public function eventDescription($event)
    {
        return strtolower(class_basename($this))."_".$event;
    }

    public static function recordableEvents()
    {
        if(isset(static::$recordableEvents)){
            return $recordableEvents = static::$recordableEvents;
        }
        return $recordableEvents = ['created', 'updated', 'deleted'];
    }

    // public function activities() : MorphMany
    // {
    //     return $this->morphMany(Activity::class, 'subject')->latest();
    // }

    public function recordActivity($description)
    {
        return $this->activities()->create([
            'description' => $description,
            'changes'     => $this->activityChanges(),
            'project_id'  => class_basename($this) === 'Project' ? $this->id : $this->project_id,
        ]);
    }

    public function activityChanges()
    {
        if($this->wasChanged()){
            return [
                'before' => \Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after'  => \Arr::except($this->getChanges(), 'updated_at'),
            ];
        }
    }

}
