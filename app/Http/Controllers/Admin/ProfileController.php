<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;

use App\ProfileHistory;

use Carbon\Carbon;

class ProfileController extends Controller
{
    //
    
    public function add()
    {
        return view('admin.profile.create');
    }

    public function create(Request $request)
    {
        
        $this->validate($request, Profile::$rules);
        
        $profile = new Profile;
        $form = $request->all();
        
        unset($profile["_token"]);
        
        $profile->fill($form)->save();
        
        return redirect('admin/profile/create');
    }
    
    public function index(Request $request)
    {
        
        $cond_name = $request->cond_name;
        
        if ($cond_name != '') {
            $posts = profile::where('name', $cond_name)->get();
        } else {
            $posts = profile::all();
        }
        
        return view('admin.profile.index', ['posts' => $posts, 'cond_name' => $cond_name]);
      
    }

    public function edit(Request $request)
    {
        
        $profile = Profile::find($request->id);
        if (empty($profile)) {
            abort(404);
        }
        
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }

    public function update(Request $request)
    {
        
        $this->validate($request, Profile::$rules);
      
        $profile = Profile::find($request->id);
      
        $profile_form = $request->all();
        
        unset($profile_form['_token']);

        $profile->fill($profile_form)->save();
        
        $profile_history = new ProfileHistory();
        $profile_history->news_id = $profile->id;
        $profile_history->edited_at = Carbon::now();
        $profile_history->save();
        
        return redirect('admin/profile');
    }
    
    public function delete(Request $request)
    {
        
        // 該当するNews Modelを取得
        $profile = Profile::find($request->id);
        
        // 削除する
        $profile->delete();
        return redirect('admin/profile/');
        
    }  
    
}

?>
