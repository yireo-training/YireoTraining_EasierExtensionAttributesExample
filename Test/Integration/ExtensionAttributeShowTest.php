<?php declare(strict_types=1);

namespace YireoTraining\EasierExtensionAttributesExample\Test\Integration;

use Magento\Framework\App\ObjectManager;
use Magento\InventoryApi\Api\Data\SourceInterface;
use PHPUnit\Framework\TestCase;

class ExtensionAttributeShowTest extends TestCase
{
    public function testIfExtensionAttributeExists()
    {
        $source = ObjectManager::getInstance()->get(SourceInterface::class);
        $extensionAttributes = $source->getExtensionAttributes();
        $this->assertNotEmpty($extensionAttributes);
        $this->assertTrue(method_exists($extensionAttributes, 'getExample'), 'Method getExample() does not exist');
        $this->assertTrue(method_exists($extensionAttributes, 'setExample'), 'Method setExample() does not exist');
    }

    public function testIfExtensionAttributeWorks()
    {
        $source = ObjectManager::getInstance()->get(SourceInterface::class);
        $extensionAttributes = $source->getExtensionAttributes();
        $extensionAttributes->setExample(true);
        $this->assertTrue($extensionAttributes->getExample());

        $extensionAttributes->setExample(false);
        $this->assertFalse($extensionAttributes->getExample());
    }
}
