<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   schema="Task",
 *   type="object",
 *   required={"title"},
 *   @OA\Property(property="id",          type="integer", format="int64", example=1),
 *   @OA\Property(property="title",       type="string",              example="Buy groceries"),
 *   @OA\Property(property="description", type="string",              example="Milk, eggs, bread"),
 *   @OA\Property(property="completed",   type="boolean",             example=false),
 *   @OA\Property(property="created_at",  type="string", format="date-time", example="2025-05-08T12:34:56Z"),
 *   @OA\Property(property="updated_at",  type="string", format="date-time", example="2025-05-08T12:34:56Z")
 * )
 *
 * @OA\Schema(
 *   schema="TaskInput",
 *   type="object",
 *   required={"title"},
 *   @OA\Property(property="title",       type="string", example="Pay bills"),
 *   @OA\Property(property="description", type="string", example="Electricity and water")
 * )
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'completed',
    ];
}

