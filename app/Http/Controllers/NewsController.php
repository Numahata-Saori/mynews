<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;

use App\News;

class NewsController extends Controller
{
    //
    
    public function index(Request $request)
    {
        //News::all()はEloquentを使った、すべてのnewsテーブルを取得するというメソッド
        //sortByDesc()というメソッドは、カッコの中の値（キー）でソートするためのメソッド
        //sortBy(‘xxx’)：xxxで昇順に並べ換える
        //sortByDesc(‘xxx’)：xxxで降順に並べ換える
        //「投稿日時順に新しい方から並べる」という並べ換えをしていることを意味
        $posts = News::all()->sortByDesc('updated_at');
        if (count($posts) > 0) {
            //shift()メソッドは、配列の最初のデータを削除し、その値を返すメソッド、配列を左にシフトする動作をするので、shiftメソッドと呼ばれる
            //$headline = $posts->shift();では、最新の記事を変数$headlineに代入し、$postsは代入された最新の記事以外の記事が格納されている
            //最新の記事とそれ以外の記事とで表記を変えたいため
            $headline = $posts->shift();
        } else {
            $headline = null;
        }

        // news/index.blade.php ファイルを渡している
        // また View テンプレートに headline、 posts、という変数を渡している
        return view('news.index', ['headline' => $headline, 'posts' => $posts]);
    }
    
}
