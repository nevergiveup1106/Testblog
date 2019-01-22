@extends('layout.main')

@section('content')

	@include('layout.adminnav')
	<div class="container">
		<div class="col-md-12">
			<div class="panel panel-default">
			  <div class="panel-body">
				<h1>{{ $blog->title }}</h1>
	      		<span>Submitted in {{ date("F j, Y, g:i a", strtotime($blog->created_at)) }}</span>
		        <p class="lead">{{ $blog->body }}</p>
			  </div>
			</div>
		</div>
		<div class="col-md-12">
			<hr>
			@foreach($blog->comments as $comment)
					
					 <span>
						{{{ $comment->name }}}</span> <br/>
					 <?php $check =  '' ; 
					if($comment->right_answer == '1') {
					 $check =  'checked';
					 echo 'test' ;	
					}
					?> 
					@if(($blog->user_id == @Auth::user()->id) &&  isset(Auth::user()->id))
					
						
					<span> <input class="update_staus"   type="checkbox" name="comment" value={{{$comment->id}}} {{$check}}> </span>
					@endif
					<p class="lead">{{{ $comment->comment }}}</p>
				<hr>
			@endforeach
		</div>
		<div class="col-md-12">
			{{ Form::open(array('url' => '/blog/comment/'. $blog->id, 'role' => 'form')) }}
	            <div class="form-group">
	            	@if(!empty($errors->first('name')))
	              		<div class="alert alert-danger">{{ $errors->first('name') }}</div>
	            	@endif
	            	{{ Form::label('name', 'Your Name') }}
	            	{{ Form::text('name', $value = null, array('class' => 'form-control', 'placeholder' => 'Your Name')) }}
	          	</div>

	          	<div class="form-group">
	            	@if(!empty($errors->first('comment')))
	             		<div class="alert alert-danger">{{ $errors->first('comment') }}</div>
	            	@endif
	            	{{ Form::label('comment', 'Comment') }}
	            	{{ Form::textarea('comment', $value = null, array('class' => 'form-control', 'rows' => '4')) }}
	          	</div>
          		{{ Form::submit('Comment Now', array('class' => 'btn btn-default')) }}
      		{{ Form::close() }}
		</div>
	</div>
@stop
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){ 
        var response = '';
	$('.update_staus').click(function() {
		var post_id = {{$blog->id}};
		
		var check_status = $(this).prop('checked');
		if(check_status == false){
			var r = confirm('Are you sure , you want to uncheck this?');
			if(r){
				var type = '0';
			}
			else{
				$(this).prop('checked',true);
			}
		}
		else{
			var r = confirm('Are you sure , you want to make it right answer?');
			if(r){
				var type = '1';
			}
			else{
				$(this).prop('checked',true);
			}
		}
		
		
        $.ajax({ 
			
			 type: "POST",   
			 url: "/update_status",   
			 data: {'type':type,'post_id' : post_id,  'comment_id' : $(this).val()},
			 success : function(text)
			 {
				 alert('Data updated successfully');
				window.location.href= '/blog/'+post_id;
			 }
        });
	})
        
});
 </script>
