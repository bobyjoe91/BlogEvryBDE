<?php
// src/EvryThing/BlogBundle/Form/BlogType.php

namespace EvryThing\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BlogType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('title', 'text');
		$builder->add('blog', 'textarea');
		$builder->add('image', 'file');
		$builder->add('tags', 'choice', array('choices' => array('article' => 'Article', 'evenement' => 'Evenement'),
				'multiple' => false,
				'expanded' => false,
				'empty_value' => '- choix du tag -',
				'empty_data'  => -1));
		$builder->add('submit', 'submit');
	}

    public function getName()
    {
        return 'blog';
    }
}