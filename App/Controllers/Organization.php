<?php namespace App\Controllers;

    use App\Lib\Request;
    use App\Lib\Response;
    use App\Lib\Router;
    use Classes\User;
    use Classes\Organization;
    use Classes\OrganizationQuery;
    use App\Helpers\Role;
    use Classes\UserQuery;
    use App\Helpers\Token;

    class Organiztion
    {
        public static function load()
        {
            //Begin Create
            Router::post('/addOrg', function(Request $req, Response $res){

                if(!Token::TokenMatching('add_org_token'))
                {
                    return " ";
                }

                $org = new User();
                $org->setFirstName($req->getBody()['first_name']);
                $org->setLastName($req->getBody()['last_name']);
                $org->setUsername($req->getBody()['username']);
                $org->setPassword(password_hash($req->getBody()['password'], PASSWORD_DEFAULT));
                $org->setEmailAddr($req->getBody()['email_addr']);
                $org->setRole(Role::EventCoordinator);
                $org->save();

                $organization = new Organization();
                $organization->setName($req->getBody()['name']);
                $organization->setUserId($org->getPrimaryKey());
                $organization->save();

                Token::TokenExpiration('add_org_token');
            });
            //End Create

            //Begin Read
            Router::post('/readOrg', function(Request $req, Response $res){

                if(!Token::TokenMatching('read_org_token'))
                {
                    return " ";
                }

                $orgUser = UserQuery::create()->findOneByUsername($req->getBody()['username']);
                
                $org = OrganizationQuery::create()->findOneByName($orgUser->getPrimaryKey());

                Token::TokenExpiration('read_org_token');

            });

            Router::post('/loadOrgs', function(Request $req, Response $res){

                if(!Token::TokenMatching('load_orgs_token'))
                {
                    return " ";
                }

                $org = OrganizationQuery::create()->find();

                Token::TokenExpiration('load_orgs_token');
            });
            //End Read

            //Begin Update
            Router::post('/updateOrg', function(Request $req, Response $res){

                if(!Token::TokenMatching('load_orgs_token'))
                {
                    return " ";
                }

                $orgUser = UserQuery::create()->findOneByUsername($req->getBody()['username']);
                $org = OrganizationQuery::create()->findOneByUserId($orgUser->getPrimaryKey());

                Token::TokenExpiration('load_orgs_token');
            });
            //End Update

            //Begin Delete
            Router::post('/deleteOrg', function(Request $req, Response $res){

                if(!Token::TokenMatching('delete_org_token'))
                {
                    return " ";
                }

                $orgUser = UserQuery::create()->findOneByUsername($req->getBody()['username']);
                $orgUser->delete();

                Token::TokenExpiration('delete_org_token');
            });
            //End Delete

        }
    }

?>