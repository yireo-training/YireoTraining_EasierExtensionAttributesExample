<?php declare(strict_types=1);

namespace YireoTraining\InventorySourceShowAttributes\Test\Integration;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\ObjectManager;
use Magento\InventoryApi\Api\Data\SourceInterface;
use Magento\InventoryApi\Api\SourceRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Yireo\EasierExtensionAttributes\ExtensionAttribute\ExtensionAttributeListing;

class SourceEntityTest extends TestCase
{
    public function testIfEasierExtensionAttributeWorks()
    {
        $easierExtensionAttributeListing = ObjectManager::getInstance()->get(ExtensionAttributeListing::class);
        $easierExtensionAttributes = $easierExtensionAttributeListing->getAll();
        
        $matchAttributeCode = false;
        $matchEntityClass = false;
        foreach ($easierExtensionAttributes as $extensionAttribute) {
            if ($extensionAttribute->getAttributeCode() === 'example') {
                $matchAttributeCode = true;
            }
            
            if ($extensionAttribute->getEntityClass() === SourceInterface::class) {
                $matchEntityClass = true;
            }
        }
        
        $this->assertTrue($matchAttributeCode);
        $this->assertTrue($matchEntityClass);
    }
    
    /**
     * @magentoDataFixture Magento_InventoryApi::Test/_files/sources.php
     * @return void
     */
    public function testIfSourceEntityCouldBeModified()
    {
        $source = $this->getRandomSourceFromRepository();
        $this->assertTrue($source->getId() > 0, 'No source found');
        
        $sourceCode = $source->getSourceCode();

        $this->saveExample($source, true);
        $this->assertSourceContainsExample($this->getSourceFromRepositoryGet($sourceCode), true);
        $this->assertSourceContainsExample($this->getSourceFromRepositoryGetList($sourceCode), true);

        $this->saveExample($source, false);
        $this->assertSourceContainsExample($this->getSourceFromRepositoryGet($sourceCode), false);
        $this->assertSourceContainsExample($this->getSourceFromRepositoryGetList($sourceCode), false);
    }

    private function saveExample(SourceInterface $source, bool $example)
    {
        $extensionAttributes = $source->getExtensionAttributes();
        $extensionAttributes->setExample($example);
        $source->setExtensionAttributes($extensionAttributes);
        $this->getSourceRepository()->save($source);
    }

    private function assertSourceContainsExample(SourceInterface $source, bool $example)
    {
        $this->assertSame($example, $source->getExtensionAttributes()->getExample());
    }

    private function getSourceFromRepositoryGet(string $sourceCode)
    {
        return $this->getSourceRepository()->get($sourceCode);
    }

    private function getSourceFromRepositoryGetList(string $sourceCode)
    {
        $searchCriteriaBuilder = ObjectManager::getInstance()->get(SearchCriteriaBuilder::class);
        $searchCriteriaBuilder->addFilter('source_code', $sourceCode);
        $searchCriteriaBuilder->setPageSize(1);
        $searchResults = $this->getSourceRepository()->getList($searchCriteriaBuilder->create());
        $sources = $searchResults->getItems();
        $source = array_shift($sources);
        return $source;
    }

    private function getSourceRepository(): SourceRepositoryInterface
    {
        return ObjectManager::getInstance()->get(SourceRepositoryInterface::class);
    }

    private function getRandomSourceFromRepository(): SourceInterface
    {
        $searchCriteriaBuilder = ObjectManager::getInstance()->get(SearchCriteriaBuilder::class);
        $searchCriteriaBuilder->setPageSize(1);
        $searchCriteria = $searchCriteriaBuilder->create();

        $sourceRepository = $this->getSourceRepository();
        $searchResult = $sourceRepository->getList($searchCriteria);
        $sources = $searchResult->getItems();

        $this->assertNotEmpty($sources);
        $source = array_shift($sources);
        $this->assertNotEmpty($source);
        return $source;
    }
}
