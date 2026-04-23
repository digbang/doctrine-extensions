<?php
namespace Digbang\DoctrineExtensions\Functions\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\TokenType;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class FilterWhereFunction extends FunctionNode
{
    public const IDENTIFIER = 'FILTER_WHERE';

    private $expresion;
    private $condition;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            '%s FILTER (WHERE %s)',
            $sqlWalker->walkStringPrimary($this->expresion),
            $sqlWalker->walkStringPrimary($this->condition));
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->expresion = $parser->AggregateExpression();
        $parser->match(TokenType::T_COMMA);
        $this->condition = $parser->ConditionalExpression();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
