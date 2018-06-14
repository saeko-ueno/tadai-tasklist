<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Task; 

class TasksController extends Controller
{
    
     
    public function index()
    {
        
        
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
            $data += $this->counts($user);
            return view('users.show', $data);
        }else {
            return view('welcome');
        }

    }

    
    public function create()
    {
         $task = new Task;

        return view('tasks.create', [
            'task' => $task,
        ]);
    }

  
    public function store(Request $request)
    {

        $this->validate($request,[
            'content' => 'required',  
            'status' => 'required',
        ]);
        
        $request->user()->tasks()->create([
            'content' => $request->content,
             'status' => 'required',
        ]);


        return redirect()->back();
    }

    
    public function show($id)
    {
        $task = Task::find($id);
        
        if (empty($task)){
            return redirect('/');
        }
        else{
        if (\Auth::user()->id===$task->user_id){

        return view('tasks.show', [
            'task' => $task,
        ]);
        }
    
       else{ 
           return redirect('/');
           
        }
        }
    }

   
    public function edit($id)
    {   
        $task = Task::find($id);
       
         if (empty($task)) {
            return redirect('/');
        }
        else{
        if (\Auth::user()->id===$task->user_id){
            
            return view('tasks.edit', [
            'task' => $task,
        ]);
        }
        
 
        
        else{
            return redirect()->back();
        }
        }
    }
            
 
       
       
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
     
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
     
    public function destroy($id)
    {
        $task = \App\Task::find($id);
        
        if(\Auth::user()->id===$task->user_id){
            $task->delete();
        }
        

        return redirect()->back();
    }
}
