<?php

namespace App\Service\Comment\Validator\Products;

use App\Service\Comment\Validator\CommentValidatorInterface;
use App\Service\Security\Authentication\Validation\Supplier\ValidationSupplierInterface;
use App\Service\Security\Validation\Objects\Comment;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CommentValidator implements CommentValidatorInterface
{
    private $commentObj;
    private $validator;
    private $validationSupplier;

    public function __construct(Comment $commentObj, ValidatorInterface $validator, ValidationSupplierInterface $validationSupplier)
    {
        $this->commentObj = $commentObj;
        $this->validator = $validator;
        $this->validationSupplier = $validationSupplier;
    }

    public function validate(?string $comment): array
    {
        $this->commentObj->setComment($comment);
        // add any property to comment object (if any is required)

        $errors = $this->validator->validate($this->commentObj);

        if (count($errors) === 0) {
            return [];
        }

        return $this->validationSupplier->convertErrorsToArray($errors);
    }
}