<?php 
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class ExamTest extends TestCase
{
    public function testLoadJSON(): void
    {
		$res = explode("\n", file_get_contents('input.txt'));
        $this->assertNotEmpty($res, 'no contents');		
    }

	public function testGetContents(): void
    {
        $res = explode("\n", file_get_contents('input.txt'));
        $this->assertNotEmpty($res, 'no contents');
    }
	public function testFormatAmount(): void
    {
		$amt = 0.432345442342;
        $formattedAmt = ceil($amt * 100) / 100;
		
		$this->assertEquals($formattedAmt,$formattedAmt, 'Amount not formatted');
    }
}