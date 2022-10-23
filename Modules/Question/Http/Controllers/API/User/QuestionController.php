<?php

namespace Modules\Question\Http\Controllers\API\User;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Question\Entities\Question;
use Modules\Question\Http\Requests\SendQuestionRequest;
use Modules\Question\Repositories\User\QuestionRepository;

class QuestionController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var QuestionRepository
     */
    protected $questionRepo;
    /**
     * @var Question
     */
    protected $question;
   

    /**
     * QuestionsController constructor.
     *
     * @param QuestionRepository $questions
     */
    public function __construct(BaseRepository $baseRepo, Question $question,QuestionRepository $questionRepo)
    {
        $this->baseRepo = $baseRepo;
        $this->question = $question;
        $this->questionRepo = $questionRepo;
    }


  
}
