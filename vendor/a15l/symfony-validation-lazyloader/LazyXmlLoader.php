<?php


namespace a15l\cmp\symfony\validator\lazyloader;

use Symfony\Component\Validator\Exception\MappingException;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Loader\XmlFileLoader;

class LazyXmlLoader extends XmlFileLoader{

    /**
     * The XML nodes of the mapping file.
     *
     * @var \SimpleXMLElement[]|null
     */
    protected $classes = array();

    /**
     * @var string
     */
    protected $configDir;

    /**
     * LazyXmlFileLoader constructor.
     * @param string $configDir
     */
    public function __construct($configDir){
        $this->configDir = $configDir;
    }


    /**
     * {@inheritdoc}
     */
    public function loadClassMetadata(ClassMetadata $metadata){
        if (!isset($this->classes[$metadata->getClassName()])) {
            // This method may throw an exception. Do not modify the class'
            // state before it completes
            $xml = $this->parseFile(trim(str_replace('\\', '.', $metadata->getClassName()), '\\') . '.xml');

            foreach ($xml->namespace as $namespace) {
                $this->addNamespaceAlias((string)$namespace['prefix'], trim((string)$namespace));
            }

            foreach ($xml->class as $class) {
                $this->classes[(string)$class['name']] = $class;
            }
        }

        if (isset($this->classes[$metadata->getClassName()])) {
            $classDescription = $this->classes[$metadata->getClassName()];

            $this->loadClassMetadataFromXml($metadata, $classDescription);

            return true;
        }

        return false;
    }

    /**
     * Loads the validation metadata from the given XML class description.
     *
     * @param ClassMetadata $metadata The metadata to load
     * @param array $classDescription The XML class description
     */
    private function loadClassMetadataFromXml(ClassMetadata $metadata, $classDescription){
        foreach ($classDescription->{'group-sequence-provider'} as $_) {
            $metadata->setGroupSequenceProvider(true);
        }

        foreach ($classDescription->{'group-sequence'} as $groupSequence) {
            if (count($groupSequence->value) > 0) {
                $metadata->setGroupSequence($this->parseValues($groupSequence[0]->value));
            }
        }

        foreach ($this->parseConstraints($classDescription->constraint) as $constraint) {
            $metadata->addConstraint($constraint);
        }

        foreach ($classDescription->property as $property) {
            foreach ($this->parseConstraints($property->constraint) as $constraint) {
                $metadata->addPropertyConstraint((string)$property['name'], $constraint);
            }
        }

        foreach ($classDescription->getter as $getter) {
            foreach ($this->parseConstraints($getter->constraint) as $constraint) {
                $metadata->addGetterConstraint((string)$getter['property'], $constraint);
            }
        }
    }

    /**
     * Loads the XML class descriptions from the given file.
     *
     * @param string $path The path of the XML file
     *
     * @return \SimpleXMLElement The class descriptions
     *
     * @throws MappingException If the file could not be loaded
     */
    protected function parseFile($path){
        $newPath = $this->configDir . DIRECTORY_SEPARATOR . $path;
        return parent::parseFile($newPath);
    }
}