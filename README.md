# テスト用スクリプトの作成
* FixtureフォルダにBoardsTableとPeopleTableのFixture.phpファイル作成
* TestCaseフォルダにBoardsTableとPeopleTableのTest.phpファイル作成

`$ vendor/bin/phpunit`コマンドでテストを実行した結果  

There was 1 failure:

1) App\Test\TestCase\Controller\BoardsControllerTest::testAddPost
Possibly related to Cake\Http\Exception\InvalidCsrfTokenException: "Missing or incorrect CSRF cookie type."

と表示され他ので、CSRF対策を行おうと思います。
