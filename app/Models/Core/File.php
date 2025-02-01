<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $file
 * @property string $name
 * @property string $ext
 * @property string $type
 * @property string $path
 * @method static where(string $string, string $string1, $file_id)
 */
class File extends Model{
    use HasFactory;

    protected $table = '__files';
    protected $guarded = ['id'];

    public function getFile(): string {
        return "/{$this->path}/{$this->name}";
    }
}
