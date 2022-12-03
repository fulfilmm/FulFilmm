<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssginmentComment;
use App\Models\ExpClaimComment;
use App\Models\order_comments;
use App\Models\SaleActivityComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function expenseClaimComment($id){
        $comment=ExpClaimComment::with('comment_user')->where('expclaim_id',$id)->get();
        return response()->json(['con'=>true,'result'=>$comment]);
    }
    public function expclaimCommmentPost(Request $request,$id){
        $comment=new ExpClaimComment();
        $comment->comment=$request->comment;
        $comment->emp_id=Auth::guard('api')->user()->id;
        $comment->expclaim_id=$id;
        $comment->save();
        return response()->json(['con'=>true,'msg'=>'Added new comment']);
    }
    public function assignmentCommentGet($id){
        $comment=AssginmentComment::with('employee')->where('assignment_id',$id)->get();
        return response()->json(['con'=>true,'result'=>$comment]);

    }
    public function assignmentCommentPost(Request $request,$id){
        $this->validate($request, [
            'comment' => 'required'
        ]);
//        dd($request->all());
        $comment = new AssginmentComment();
        if(isset($request->attach)) {
//            dd('hell');
            $attach = $request->file('attach');
            $input['filename'] =\Illuminate\Support\Str::random(10).time().'.'.$attach->getClientOriginalExtension();
            $request->attach->move(public_path() . '/attach_file/', $input['filename']);
            $comment->attach =$input['filename'];
        }
        $comment->emp_id =Auth::guard('api')->user()->id;
        $comment->assignment_id = $id;
        $comment->comment = $request->comment;
//        dd($comment);
        $comment->save();
        return response()->json(['con'=>true,'msg'=>'Added new comment']);

    }
    public function orderCommentGet($id){
        $comment=order_comments::with('employee')->orderBy('id','desc')->where('order_id',$id)->get();
        return response()->json(['con'=>true,'result'=>$comment]);

    }
    public function orderCommentPost(Request $request,$id){
        if($request->comment_text!=null){
            $order_comment=new order_comments();
            $order_comment->order_id=$id;
            $order_comment->emp_id=Auth::guard('api')->user()->id;
            $order_comment->comment_text=$request->comment_text;
            $order_comment->save();
            $comment=order_comments::with('employee')->where('id',$order_comment->id)->first();
        }

        return response()->json(['con'=>true,'result'=>$comment->id]);

    }
    public function saleactivityCommentGet($id){
        $comment=SaleActivityComment::with('user')->where('saleactivity_id',$id)->get();
        return response()->json(['con'=>true,'result'=>$comment]);

    }
    public function saleactivityCommentPost(Request $request,$id){
        $comment=new SaleActivityComment();
        $comment->comment=$request->comment;
        $comment->saleactivity_id=$id;
        $comment->emp_id=Auth::guard('api')->user()->id;
        $comment->save();
        return response()->json(['con'=>true,'msg'=>'Added new comment']);

    }
}
