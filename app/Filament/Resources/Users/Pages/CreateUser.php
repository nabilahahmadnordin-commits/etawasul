<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function fillForm(): void
    {
        $this->callHook('beforeFill');

        $this->form->fill([
            'password' =>  Str::password(16),
        ]);

        $this->callHook('afterFill');
    }

    protected function handleRecordCreation(array $data): Model
    {
        // 
        if (!empty($data['send_user_notification'])) {
            dd($data);
        }
        $record = new ($this->getModel())($data);

        if ($parentRecord = $this->getParentRecord()) {
            return $this->associateRecordWithParent($record, $parentRecord);
        }

        $record->save();

        return $record;
    }

    protected function getRedirectUrl(): string
    {
        $resource = static::getResource();

        return $resource::getUrl('index');
    }
}
