-- @tag: knowledge
-- @description: creates Table for kowledge
-- @version: 2.1.0
DROP TABLE IF EXISTS knowledge_category;
CREATE TABLE knowledge_category (
    id       SERIAL,
    labeltext text,
    maingroup int,
    help    bool

);
DROP TABLE IF EXISTS tmp;
CREATE TABLE tmp (
    id       SERIAL,
    labeltext text,
    maingroup int,
    help    bool,
    oldid      int
);
DROP TABLE IF EXISTS knowledge_content;
CREATE TABLE knowledge_content (
    id          SERIAL,
    modifydate  TIMESTAMP,
    content     TEXT,
    employee    INT,
    version     INT,
    category    INT,
    owner       INT
);

INSERT INTO knowledge_category (labeltext, maingroup, help) SELECT name, hauptgruppe, kdhelp FROM wissencategorie;
INSERT INTO tmp (labeltext, maingroup, help, oldid) SELECT name, hauptgruppe, kdhelp, id FROM wissencategorie;
INSERT INTO knowledge_content (initdate, content, employee, version, category, owner) SELECT initdate, content, employee, version, categorie, owener FROM wissencontent;
UPDATE knowledge_category SET maingroup = (SELECT id FROM tmp WHERE tmp.oldid = knowledge_category.maingroup) WHERE knowledge_category.maingroup != 0;
DELETE FROM knowledge_category WHERE labeltext = NULL OR labeltext = '' OR maingroup IS NULL;
UPDATE knowledge_content SET category = (SELECT id FROM tmp WHERE tmp.oldid = knowledge_content.category);
DELETE FROM knowledge_content WHERE category IS NULL;


DROP TABLE tmp;
