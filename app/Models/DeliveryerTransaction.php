<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DeliveryerTransaction
 *
 * @property int $id
 * @property int $deliveryer_id
 * @property string $amount
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereDeliveryerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DeliveryerTransaction extends Model
{
    use HasFactory, HasDates;

    protected $table = 'deliveryer_transaction';
    protected $fillable = ['deliveryer_id', 'amount', 'type', 'note'];
}
