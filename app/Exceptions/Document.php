<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';
    protected $primaryKey = 'document_id';

    public function user(){
        return $this->belongsTo('App\User', 'created_by', 'user_id');
    }

    public function tags(){
        return $this->hasMany('App\DocumentTag', 'doc_idFk', 'document_id');
    }

    public function check_tags($document_id, $tag_id){
        return DocumentTag::where('doc_idFk', $document_id)->where('tag_idFk', $tag_id)->exists();
    }

    public function readMore($string){
        if (strlen($string) > 150) {

            // truncate string
            $stringCut = substr($string, 0, 150);

            // make sure it ends in a word so assassinate doesn't become ass...
            $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'....  ';
        }
        return $string;
    }
}
