<?php

namespace OADocumentor;

use Illuminate\Filesystem\Filesystem;
use OADocumentor\Exceptions\DocumentationValidationException;
use OADocumentor\Exceptions\InvalidFileTypeException;
use cebe\openapi\Reader;
use Symfony\Component\Yaml\Yaml;

class Documentor
{
    /** @var array $documentation */
    protected $documentation;
    /** @var Schema $schema */
    protected $schema;
    /** @var Filesystem $fs */
    protected $fs;
    /** @var bool isValid */
    protected $isValid = false;
    /** @var string $format */
    protected $format = 'yml';

    public function __construct(Filesystem $fs)
    {
        $this->fs = $fs;
    }

    /**
     * Reads the files in the docs folder and merges
     * the content into a array and transforms it
     * into a json file that can be published.
     *
     * @return void
     */
    public function generate()
    {
        $this->documentation = $this->fs->getRequire(__DIR__ . "/../config/openapi.php");
        $this->determineFileFormat();
        $this->mergePathFiles();
        $this->mergeComponentFiles();

        return $this;
    }

    /**
     * @return void
     */
    public function createDocsDirectory()
    {
        if (!$this->fs->isDirectory(public_path(config('documentor.save.path')))) {
            $this->fs->makeDirectory(
                public_path(config('documentor.save.path')),
                0755,
                true
            );
        }
    }

    /**
     * @return void
     * throws InvalidFileTypeException
     */
    public function determineFileFormat(): void
    {
        $allowedExtensions = ['json', 'yml'];
        $filename = explode('.', config('documentor.save.filename'));
        $extension = end($filename);

        if (in_array($extension, $allowedExtensions)) {
            $this->format = $extension;
        } else {
            throw new InvalidFileTypeException(
                "The file type `{$extension}` is not valid. Please use one of the following [" . implode(', ', $allowedExtensions) . "]"
            );
        }
    }

    /**
     * @return bool
     */
    public function save()
    {
        if ($this->isValid) {
            $docs = $this->format == 'yml' ? $this->toYml() : $this->toJson();

            $this->createDocsDirectory();
            $this->fs->put(public_path(config('documentor.save.path') . '/' . config('documentor.save.filename')), $docs);

            return true;
        }
        throw new DocumentationValidationException('The documentation data has not yet been validated. Make sure you validate the data before saving it.');
    }

    /**
     * Reads all the files from the paths configured folder.
     *
     * @return void
     */
    private function mergePathFiles()
    {
        $files = collect($this->fs->allFiles(config('documentor.directories.paths')));
        $this->documentation['paths'] = [];
        $files->each(function ($pathFile) {
            $content = $this->fs->getRequire($pathFile->getPathName());
            $this->documentation['paths'] = array_merge($this->documentation['paths'], $content);
        });
    }

    /**
     * Read all the files from the components folder.
     * The file names must represent the desired name of
     * the component generated to the #/components/schemas.
     *
     * @return void
     */
    private function mergeComponentFiles(): void
    {
        $files = collect($this->fs->allFiles(config('documentor.directories.components')));
        $files->each(function ($componentFile) {
            $entity = ucfirst($componentFile->getFilenameWithoutExtension());
            $content = $this->fs->getRequire($componentFile->getPathName());
            $this->documentation['components']['schemas'][$entity] = $content;
        });
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->documentation;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return collect($this->documentation)->toJson(JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * @return string
     */
    public function toYml()
    {
        return Yaml::dump($this->documentation);
    }

    /**
     * @return Documentor
     * @throws DocumentationValidationException
     */
    public function validate()
    {
        $openapi = Reader::readFromJson($this->toJson());
        if ($openapi->validate()) {
            $this->isValid = true;
            return $this;
        }

        throw new DocumentationValidationException(implode(PHP_EOL, $openapi->getErrors()));
    }
}
