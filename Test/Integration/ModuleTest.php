<?php declare(strict_types=1);

namespace YireoTraining\EasierExtensionAttributesExample\Test\Integration;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Module\ModuleList;
use PHPUnit\Framework\TestCase;

class ModuleTest extends TestCase
{
    public function testIfModulesWork()
    {
        $moduleList = ObjectManager::getInstance()->get(ModuleList::class);
        $modules = array_keys($moduleList->getAll());
        sort($modules);
        
        $this->assertTrue($moduleList->isModuleInfoAvailable());
        
        $module = $moduleList->getOne('Yireo_EasierExtensionAttributes');
        $this->assertNotEmpty($module, var_export($modules, true));
    
        $module = $moduleList->getOne('YireoTraining_EasierExtensionAttributesExample');
        $this->assertNotEmpty($module, var_export($modules, true));
    }
}