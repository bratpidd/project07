
BEGIN;

-----------------------------------------------------------------------
-- post
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "post" CASCADE;

CREATE TABLE "post"
(
    "id" serial NOT NULL,
    "message" VARCHAR(1024) NOT NULL,
    PRIMARY KEY ("id")
);

-----------------------------------------------------------------------
-- tag
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "tag" CASCADE;

CREATE TABLE "tag"
(
    "id" serial NOT NULL,
    "title" VARCHAR(128) NOT NULL,
    PRIMARY KEY ("id"),
    CONSTRAINT "uq_tag_title" UNIQUE ("title")
);

-----------------------------------------------------------------------
-- post_tag
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "post_tag" CASCADE;

CREATE TABLE "post_tag"
(
    "post_id" INTEGER NOT NULL,
    "tag_id" INTEGER NOT NULL,
    PRIMARY KEY ("post_id","tag_id")
);

-----------------------------------------------------------------------
-- comment
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "comment" CASCADE;

CREATE TABLE "comment"
(
    "id" serial NOT NULL,
    "text" VARCHAR(512) NOT NULL,
    "post_id" INTEGER NOT NULL,
    PRIMARY KEY ("id")
);

ALTER TABLE "post_tag" ADD CONSTRAINT "post_tag_fk_ed85ac"
    FOREIGN KEY ("post_id")
    REFERENCES "post" ("id");

ALTER TABLE "post_tag" ADD CONSTRAINT "post_tag_fk_022a95"
    FOREIGN KEY ("tag_id")
    REFERENCES "tag" ("id");

ALTER TABLE "comment" ADD CONSTRAINT "comment_fk_post"
    FOREIGN KEY ("post_id")
    REFERENCES "post" ("id");

COMMIT;
