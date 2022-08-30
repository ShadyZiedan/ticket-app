<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\HttpClientException;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'due_date',
        'author_user_id',
        'performer_user_id',
        'status_id',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_user_id');
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performer_user_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function canTransition(Status $newStatus): bool
    {
        if ($this->status_id === $newStatus->id) {
            return true;
        }

        return match ($this->status_id) {
            StatusEnum::OPEN => !empty($this->performer_user_id) && $newStatus->isInProcess(),
            StatusEnum::IN_PROCESS => !empty($this->performer_user_id) && $newStatus->isClosed(),
            StatusEnum::CLOSED => false,
            default => throw new HttpClientException('Unknown status'),
        };
    }
}
