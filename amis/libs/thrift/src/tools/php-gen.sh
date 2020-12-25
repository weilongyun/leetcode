
rm -rf ./builds
mkdir ./builds

thrift --gen php:oop -o ./builds if/share/fb303/fb303.thrift
thrift --gen php:oop -o ./builds if/scribe/scribe.thrift 
thrift --gen php:oop -o ./builds if/hive/TCLIService.thrift 

#thrift --gen php:oop -o ./builds if/ql/queryplan.thrift 
#thrift --gen php:oop -o ./builds if/metastore/hive_metastore.thrift
#thrift --gen php:oop -o ./builds if/service/hive_service.thrift 
#thrift --gen php:oop -o ./builds if/service/simplified_hive_service.thrift

