<?php
/**
 * Copyright 2013 Bezalel Hermoso <bezalelhermoso@gmail.com>
 * 
 * This project is free software released under the MIT license:
 * http://www.opensource.org/licenses/mit-license.php 
 */

namespace Bez\ZfViewBundle\View\Helper;


use Symfony\Component\Translation\TranslatorInterface;
use Zend\View\Helper\AbstractHelper;

/**
 * Class Translation
 *
 * Handles translations -- both simple and pluralizations -- within views.
 *
 * @author Bezalel Hermoso <bezalelhermoso@gmail.com>
 * @package Bez\ZfViewBundle\View\Helper
 */
class Translation extends AbstractHelper
{
    protected $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function __invoke($message = null, array $arguments = array(), $domain = null, $locale = null)
    {
        if ($message === null
        && count($arguments) == 0
        && $domain === null
        && $locale === null
        ) {
            return $this;
        } else {

            return $this->translator->trans(
                                        $message,
                                        $arguments,
                                        $domain ?: 'messages',
                                        $locale
                                    );
        }
    }

    public function choice($message, $count, array $arguments = array(), $domain = null, $locale = null)
    {
        return $this->translator->transChoice(
                        $message,
                        $count,
                        array_merge(array('%count%' => $count), $arguments),
                        $domain ?: 'messages',
                        $locale
               );
    }
} 