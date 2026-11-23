<?php

namespace Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\PHPat;
use PHPat\Test\Builder\TargetExcludeOrTipOrBuildStep;


final class ModuleArchitectureTest
{
    public function test_state_machines_must_not_depend_on_http(): TargetExcludeOrTipOrBuildStep
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\StateMachines'))
            ->shouldNot()
            ->dependOn()
            ->classes(Selector::inNamespace('App\Http'));
    }

    public function test_models_must_not_depend_on_http(): TargetExcludeOrTipOrBuildStep
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\Models'))
            ->shouldNot()
            ->dependOn()
            ->classes(Selector::inNamespace('App\Http'));
    }

    public function test_enums_must_not_depend_on_http(): TargetExcludeOrTipOrBuildStep
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\Enums'))
            ->shouldNot()
            ->dependOn()
            ->classes(Selector::inNamespace('App\Http'));
    }

    public function test_policies_must_not_depend_on_http_controllers(): TargetExcludeOrTipOrBuildStep
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\Policies'))
            ->shouldNot()
            ->dependOn()
            ->classes(Selector::inNamespace('App\Http\Controllers'));
    }

    public function test_actions_must_not_depend_on_http_controllers(): TargetExcludeOrTipOrBuildStep
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\Actions'))
            ->shouldNot()
            ->dependOn()
            ->classes(Selector::inNamespace('App\Http\Controllers'));
    }


    public function test_invoice_application_must_not_depend_on_presentation(): TargetExcludeOrTipOrBuildStep
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\Modules\Invoice\Application'))
            ->shouldNot()
            ->dependOn()
            ->classes(Selector::inNamespace('App\Http'));
    }

    public function test_invoice_application_must_not_depend_on_infrastructure(): TargetExcludeOrTipOrBuildStep
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('App\Modules\Invoice\Application'))
            ->shouldNot()
            ->dependOn()
            ->classes(Selector::inNamespace('App\Modules\Invoice\Infrastructure'));
    }

}
