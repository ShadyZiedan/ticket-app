<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\HttpClientException;

class Status extends Model
{
    use HasFactory;


    /**
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->id === StatusEnum::OPEN;
    }

    /**
     * @return bool
     */
    public function isInProcess(): bool
    {
        return $this->id === StatusEnum::IN_PROCESS;
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->id === StatusEnum::CLOSED;
    }


}
