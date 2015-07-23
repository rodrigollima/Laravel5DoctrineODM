<?php namespace Rlima\Laravel5DoctrineODM;

interface ODM
{
    public function getDocumentManager();

    public function persist($document);

    public function flush($document, $options);
}