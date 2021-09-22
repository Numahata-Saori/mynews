<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\News;

use App\History;

use Carbon\Carbon;

class NewsController extends Controller
{
    //
    
    public function add()
    {
        
        //admin/newsディレクトリ配下のcreate.blade.php というファイルを呼び出す
        return view ('admin.news.create');
        
    }
    
    //このRequestクラスは、ブラウザを通してユーザーから送られる情報をすべて含んでいるオブジェクトを取得することができる、$requestに代入して使用
    public function create(Request $request)
    {
        
        //Varidationを行う
        //$thisは擬似変数と呼ばれ、呼び出し元のオブジェクトへの参照を意味、メソッドの中でクラスに定義された変数を使用したいときにこの$thisを使用
        //validate()の第一引数にリクエストのオブジェクトを渡し、$request->all()を判定して、問題があるなら、エラーメッセージと入力値とともに直前のページに戻る機能
        //このvalidateは、ValidateRequestsのトレイトのメソッドで宣言
        //ValidateRequestsは、app/Http/Controllers/Admin/NewsController.phpの中で宣言されている「use App\Http\Controllers\Controller; 」がController.phpを呼び出し、
        //その中の「use Illuminate\Foundation\Validation\ValidatesRequests;」で呼び出されている
        $this->validate($request, News::$rules);

        //newはModelからインスタンス（レコード）を生成するメソッド、厳密にはテーブルが生成されるのではなく、レコードが生成される
        $news = new News;
        //$request->all();はformで入力された値を取得することができる、$request->all()でユーザーが入力したデータを取得できる
        $form = $request->all();

        //dd($form);

        // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
        //issetメソッド、このメソッドは引数の中にデータがあるかないかを判断するメソッド
        //引数がnullまたはfalseならば、falseを返し、それ以外ならtrueを返す仕様になっている、投稿画面で画像を選択していれば$form[’image’]にデータが入り、選択していなければnull

        //画像を選択していた場合、つまりif文がtrueの場合、fileメソッド、Illuminate\Http\UploadedFileクラスのインスタンスを返すメソッド、画像をアップロードするメソッド
        //storeメソッド、どこのフォルダにファイルを保存するか、パスを指定するメソッド
        //news->image_path = basename($path); → $pathの中は「public/image/ハッシュ化されたファイル名」、
        //newsテーブルのimage_pathには、ファイル名のみを保存させたいのて、パスではなくファイル名だけ取得するメソッド、basenameを使用、
        //最後のハッシュ化されたファイル名を取得することができる、このファイル名をnewsテーブルのimage_pathに代入
        
        if (isset($form['image'])) {
        $path = $request->file('image')->store('public/image');
        $news->image_path = basename($path);
        
        //先に選択しなかったnullの場合、つまりelse以降の文、$news->image_path = null;はNewsテーブルのimage_pathカラムにnullを代入するという意味
        } else {
          $news->image_path = null;
        }

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        
        // フォームから送信されてきたimageを削除する
        unset($form['image']);

        // データベースに保存する
        $news->fill($form)->save();
        
        // admin/news/createにリダイレクトする
        return redirect('admin/news/create');
      
    }  
    
    public function index(Request $request)
    {
        
        //$requestにcond_titleがなければnullが代入
        //cond_title → 最後のreturn view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);がRequestにcond_titleを送っている、最初に開いた段階では、cond_titleは存在しない
        //投稿したニュースを検索するための機能として活用
        $cond_title = $request->cond_title;
        
        //
        if ($cond_title != '') {
            // 検索されたら検索結果を取得する
            //$cond_titleにデータが存在する場合
            //whereメソッドを使うと、newsテーブルの中のtitleカラムで$cond_title（ユーザーが入力した文字）に一致するレコードをすべて取得することができる
            //取得したテーブルを$posts変数に代入
            //$cond_titleがあればそれに一致するレコードを、なければすべてのレコードを取得することになる
            $posts = News::where('title', $cond_title)->get();
            
        } else {
            // それ以外はすべてのニュースを取得する
            //$cond_titleがnullの場合
            //News Modelを使って、データベースに保存されている、newsテーブルのレコードをすべて取得し、変数$postsに代入しているという意味
            $posts = News::all();
        }
        
        //index.blade.phpのファイルに取得したレコード（$posts）と、ユーザーが入力した文字列（$cond_title）を渡し、ページを開く
        //ControllerではModelに対して where メソッドを指定して検索、where への引数で検索条件を設定
        return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }
    
    public function edit(Request $request)
    {
        
        // News Modelからデータを取得する
        $news = News::find($request->id);
        if (empty($news)) {
            abort(404);    
        }
        return view('admin.news.edit', ['news_form' => $news]);
    }


    public function update(Request $request)
    {
        
        // Validationをかける
        $this->validate($request, News::$rules);
        
        // News Modelからデータを取得する
        $news = News::find($request->id);
        
        // 送信されてきたフォームデータを格納する
        $news_form = $request->all();
        
        if ($request->remove == 'true') {
            $news_form['image_path'] = null;
        } elseif ($request->file('image')) {
            $path = $request->file('image')->store('public/image');
            $news_form['image_path'] = basename($path);
        } else {
            $news_form['image_path'] = $news->image_path;
        }
        
        unset($news_form['image']);
        unset($news_form['remove']);
        unset($news_form['_token']);

        // 該当するデータを上書きして保存する
        $news->fill($news_form)->save();
        
        $history = new History();
        $history->news_id = $news->id;
        $history->edited_at = Carbon::now();
        $history->save();

        return redirect('admin/news');
    }
    
    public function delete(Request $request)
    {
        // 該当するNews Modelを取得
        $news = News::find($request->id);
        
        // 削除する
        $news->delete();
        return redirect('admin/news/');
    }
    
}
