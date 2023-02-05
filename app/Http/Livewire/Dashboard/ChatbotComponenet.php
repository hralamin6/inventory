<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\Http\Request;
use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;

class ChatbotComponenet extends Component
{
    public $title='create 5 multiple choice questions about Dhaka including options with answers', $content, $parts = [];
    public $answer=[],$result=0, $isLoaded=false, $isSubmitted = false;
    public function generate()
    {
        if ($this->title != null) {
            $result = OpenAI::completions()->create([
                "model" => "text-davinci-003",
                'prompt' => sprintf($this->title),
                'temperature'=> 0,
                'max_tokens'=> 500,
                'top_p'=> 1,
                'frequency_penalty'=> 0,
                'presence_penalty'=> 0,
            ]);
            $this->content = trim($result['choices'][0]['text']);
        }
    }

    public function quizMake()
    {
        $parts = explode('*',str_replace(array('1.','2.','3.','4.','5.','6.','7.','8.','9.','10.','11.'),'*', $this->content));
        array_shift($parts);
        foreach ($parts as $i => $part){
            $options = explode('*',str_replace(array('A.','B.','C.','D.', 'Answer:'),'*', $part));
            $this->parts[$i]=(['title'=>explode('?', $part)[0], 'a'=>$options[1],'b'=>$options[2],'c'=>$options[3],'d'=>$options[4], 'ans'=>$options[6]]);
        }
        $this->isLoaded = true;
    }

    public function submit()
    {
        if ($this->answer!=null){
            $this->result = 0;
            foreach ($this->parts as $i =>$part){
//                dd(preg_replace( "/\r\n|\r|\n/", "", trim($this->parts[$i]['ans'] )), $this->answer[$i]);
                if (trim($this->answer[$i])===preg_replace( "/\r\n|\r|\n/", "", trim($this->parts[$i]['ans'] ))){
                    $this->result++;
                }
            }
            $this->isSubmitted = true;
        }
    }

    public function tryAgain()
    {
        $this->isSubmitted = false;

    }
    public function render()
    {

        return view('livewire.dashboard.chatbot-componenet');
    }
}
//make 3 multiple choice questions about Dhaka including options with answer
