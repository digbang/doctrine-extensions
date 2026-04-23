<?php
namespace Digbang\DoctrineExtensions\Functions\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\TokenType;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class DateTruncFunction extends FunctionNode
{
    public const IDENTIFIER = 'DATE_TRUNC';

    private $date;
    private $precision;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'date_trunc(%s, %s)',
            $sqlWalker->walkStringPrimary($this->precision),
            $sqlWalker->walkArithmeticPrimary($this->date));
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->precision = $parser->StringExpression();
        $parser->match(TokenType::T_COMMA);
        $this->date = $parser->ArithmeticExpression();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
