<?php

namespace App\Service\Comment\AjaxHandler\Products;

use App\Service\Comment\AjaxHandler\AjaxHandlerInterface;
use App\Service\Comment\CommentSupplierInterface;
use App\Service\Comment\Validator\CommentValidatorInterface;

// DEV
use App\Service\DatabaseHighLvlManipulation\Insertion\Comment\CommentInsertionInterface;
use App\Service\Restaurant\UserRestaurantInteraction\Visiting\VisitDescriberInterface;
use Psr\Log\LoggerInterface;

class AjaxHandler implements AjaxHandlerInterface
{
    private $commentSupplier;
    private $commentValidator;
    private $visitDescriber;
    private $commentInsertion;

    // DEV
    private $logger;

    public function __construct(CommentSupplierInterface $commentSupplier,
                                CommentValidatorInterface $commentValidator,
                                VisitDescriberInterface $visitDescriber,
                                CommentInsertionInterface $commentInsertion,
                                LoggerInterface $logger)
    {
        $this->commentSupplier = $commentSupplier;
        $this->commentValidator = $commentValidator;
        $this->visitDescriber = $visitDescriber;
        $this->commentInsertion = $commentInsertion;

        // DEV
        $this->logger = $logger;
    }

    public function addComment(int $restaurantId): bool
    {
        $comment = $this->commentSupplier->getCommentFromPhpInputFile();

        if (!$comment) {
            return false;
        }

        // comment validation
        $errors = $this->commentValidator->validate($comment);

        if ($errors) {
            return false;
        }

        // make sure that user has visited this restaurant before
        if (!$this->visitDescriber->visitedByUser($restaurantId)) {
            return false;
        }

        // make database record
        $this->commentInsertion->insertToDatabase($comment, $restaurantId);

        // addition is complete
        return true;
    }
}