<?php

namespace Egzakt\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Egzakt\DoctrineBehaviorsBundle\Model as EgzaktORMBehaviors;

/**
 * Document
 */
class Document extends Media
{
    use EgzaktORMBehaviors\Uploadable\Uploadable;

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return 'document';
    }

     /**
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getDocumentFile()
    {
        return $this->document;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function setDocumentFile($file)
    {
        $this->document = $file;
    }

    public function getRouteBackend($action = 'edit')
    {
        if ('list' === $action) {
            return 'egzakt_media_backend_media';
        }

        return 'egzakt_media_backend_document_' . $action;
    }

    public function getReplaceRegex()
    {
        return sprintf('/(<a [^>]*data-mediaid="%d"[^>]*href=")[^>]+("[^>]*>)[^<]+(<\/a>)/', $this->getId());
    }

    public function getReplaceUrl()
    {
        return $this->getMediaPath();
    }

    /**
     * Set Upload Path
     *
     * @param $field
     * @param $uploadPath
     */
    public function setUploadPath($field, $uploadPath)
    {
        $this->uploadableFieldExists($field);

        $pathArray = $this->getUploadableFields();

        $this->{$field . 'Path'} = $pathArray[$field] . '/' . $uploadPath;
    }
}