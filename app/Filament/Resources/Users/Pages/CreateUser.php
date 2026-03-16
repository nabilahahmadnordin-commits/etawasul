<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
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
            $remember_token = base64_encode(Str::random(5)."###".$data['email']) ;
            $content = "Name: {$data['name']}\n\n";
            $content .= "To set your password, visit the following address:\n\n";
            $content .= url('/change-password') . "?key={$remember_token}";

            Mail::raw($content, function ($message) use($data) {
                $message->to($data['email'])
                    ->subject('Your Login Details');
            });
            $data['remember_token'] = $remember_token;
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
