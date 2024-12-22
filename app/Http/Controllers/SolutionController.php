<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SolutionController extends Controller
{
    public function industrialChemicals()
    {
        return view('solutions.industrial-chemicals', [
            'title' => 'Industrial Chemicals',
            'description' => 'Our comprehensive range of industrial chemicals serves diverse sectors including manufacturing, processing, and treatment applications.',
            'features' => [
                'High-purity industrial grade chemicals',
                'Bulk and custom packaging options',
                'Technical support and consultation',
                'Strict quality control measures',
                'Competitive pricing',
                'Fast and reliable delivery'
            ]
        ]);
    }

    public function laboratorySolutions()
    {
        return view('solutions.laboratory-solutions', [
            'title' => 'Laboratory Solutions',
            'description' => 'Advanced laboratory solutions for research institutions, educational facilities, and industrial testing labs.',
            'features' => [
                'Analytical grade chemicals',
                'Laboratory equipment and supplies',
                'Calibration services',
                'Method development support',
                'Quality assurance protocols',
                'Technical documentation'
            ]
        ]);
    }

    public function customFormulations()
    {
        return view('solutions.custom-formulations', [
            'title' => 'Custom Formulations',
            'description' => 'Tailored chemical formulations designed to meet your specific requirements and applications.',
            'features' => [
                'Custom blend development',
                'Formulation optimization',
                'Scale-up assistance',
                'Regulatory compliance support',
                'Stability testing',
                'Packaging solutions'
            ]
        ]);
    }

    public function safetyEquipment()
    {
        return view('solutions.safety-equipment', [
            'title' => 'Safety Equipment',
            'description' => 'High-quality safety equipment and personal protective gear for chemical handling and laboratory operations.',
            'features' => [
                'Personal protective equipment (PPE)',
                'Chemical handling equipment',
                'Safety storage solutions',
                'Emergency response equipment',
                'Training and certification',
                'Regular safety audits'
            ]
        ]);
    }

    public function qualityControl()
    {
        return view('solutions.quality-control', [
            'title' => 'Quality Control',
            'description' => 'Comprehensive quality control services ensuring the highest standards in chemical products and processes.',
            'features' => [
                'Quality testing services',
                'Process validation',
                'Documentation and reporting',
                'Compliance monitoring',
                'Quality management systems',
                'Continuous improvement programs'
            ]
        ]);
    }

    public function rdServices()
    {
        return view('solutions.rd-services', [
            'title' => 'R&D Services',
            'description' => 'Innovative research and development services to help you create next-generation chemical solutions.',
            'features' => [
                'Product development',
                'Process optimization',
                'Analytical services',
                'Feasibility studies',
                'Technology transfer',
                'Collaborative research'
            ]
        ]);
    }
}
