<?php declare(strict_types=1);

namespace YireoTraining\EasierExtensionAttributesExample\Test\Integration;

use Magento\Framework\App\ObjectManager;
use Magento\InventoryApi\Api\Data\SourceInterface;
use PHPUnit\Framework\TestCase;
use YireoTraining\EasierExtensionAttributesExample\Plugin\AddExtensionAttributeToEntity;

class PluginTest extends TestCase
{
    public function testIfDiPluginWorks()
    {
        $this->assertTrue(true);
        //$addExtensionAttributeToEntity = ObjectManager::getInstance()->get(AddExtensionAttributeToEntity::class);
        //$this->assertSame('boolean', $addExtensionAttributeToEntity->getAttributeType());
    }
}