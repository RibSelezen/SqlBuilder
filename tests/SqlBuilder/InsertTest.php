<?php

namespace SqlBuilder;

use PHPUnit\Framework\TestCase;
use SqlBuilder\QueryPart\Column\Column;

class InsertTest extends TestCase
{
    public function testBuildSql(): void
    {
        $insertStmt = new Insert("Users");
        $this->assertEquals("INSERT INTO Users VALUES ()", $insertStmt->toSQL());

        $insertStmt = new Insert("Users");
        $insertStmt->setColumns(['name', 'surname', 'age']);
        $this->assertEquals("INSERT INTO Users (name, surname, age) VALUES ()", $insertStmt->toSQL());

        $insertStmt = new Insert("Users");
        $insertStmt->setColumns(['name', 'surname', 'age'])
            ->setValues(['John', 'Smith', 25]);
        $this->assertEquals("INSERT INTO Users (name, surname, age) VALUES ('John', 'Smith', 25)", $insertStmt->toSQL());

        $insertStmt = new Insert("Users");
        $insertStmt->setColumns(['name', 'surname', 'age'])
            ->setValues([['John', 'Smith', 25], ['Alan', 'Clark']]);
        $this->assertEquals("INSERT INTO Users (name, surname, age) VALUES ('John', 'Smith', 25), ('Alan', 'Clark')", $insertStmt->toSQL());

        $selectStmt = new Select("Clients");
        $selectStmt->addColumn(new Column("name"));
        $selectStmt->addColumn(new Column("surname"));
        $selectStmt->addColumn(new Column("age"));
        $insertStmt = new Insert("Users");    
        $insertStmt->setColumns(['name', 'surname', 'age'])
            ->setSelect($selectStmt);
        $this->assertEquals("INSERT INTO Users (name, surname, age) SELECT name, surname, age FROM Clients", $insertStmt->toSQL());
    }
}
