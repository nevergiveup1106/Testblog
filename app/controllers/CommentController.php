<?php

class CommentController extends \BaseController {

	public function comment($id)
	{
		$rules = array(
            'name'     => 'required',
            'comment'      => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/blog/comment/'.$id)
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else { 
			if (Auth::check())
			{ 
				// store
				$comment = new Comment;
				$comment->post_id       = $id;
				$comment->name       = Input::get('name');
				$comment->comment      = Input::get('comment');
				$comment->user_id      = Auth::user()->id;
				$comment->save();
				
				return Redirect::to('/blog/'.$id);
			} else  { 
				
				Session::put('blogid', $id);
				return Redirect::to('/admin/');
				
			}
           
        }
	}
	
	public function update_status() {			
		
		Comment::where('post_id', $_REQUEST['post_id'])->update(array('right_answer' => '0'));
		
		
		if($_REQUEST['type'] == 1){
			$Comment = Comment::find($_REQUEST['comment_id']);
			$Comment->right_answer       = '1';
			$Comment->save();
		}
		 echo 'true';
	}

}
