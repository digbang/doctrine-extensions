<?php
namespace Digbang\DoctrineExtensions\Functions\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\TokenType;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class UnaccentFunction extends FunctionNode
{
    public const IDENTIFIER = 'UNACCENT';

    /** @var Node */
    private $string;

    /**
     * @param SqlWalker $sqlWalker
     *
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker): string
    {
        return 'unaccent(' . $this->string->dispatch($sqlWalker) . ')';
    }

    /**
     * @param Parser $parser
     *
     * @return void
     */
    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->string = $parser->StringExpression();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
