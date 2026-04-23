<?php

namespace Digbang\DoctrineExtensions\Functions\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\PathExpression;
use Doctrine\ORM\Query\TokenType;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class DistinctOnFunction extends FunctionNode
{
    public const IDENTIFIER = 'DISTINCT_ON';

    private $field;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'distinct on (%1$s) %1$s',
                $sqlWalker->walkStringPrimary($this->field));
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->field = $parser->PathExpression(PathExpression::TYPE_STATE_FIELD);
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
