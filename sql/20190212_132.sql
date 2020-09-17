     ALTER TABLE "public"."anotacion"
  ADD COLUMN "id_ramo" INTEGER;

ALTER TABLE "public"."anotacion"
  ALTER COLUMN "id_ramo" SET DEFAULT 0;
  
update anotacion set id_ramo = 0;