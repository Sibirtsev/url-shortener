<?php
namespace UrlBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UrlFormat extends Constraint
{
    /**
     * @var string
     */
    public $message = 'The URL "{{ string }}" not valid';
}