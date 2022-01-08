<?php

namespace PW_runningExample_v6_Laravel;

use PW_runningExample_v6_Laravel\Book;
use PW_runningExample_v6_Laravel\Author;

class DataLayer {

    public function listBooks($user) {
        
        //$connection = $this->db_connect();

        //$sql = "SELECT * FROM book WHERE user_id = " . $user 
        //        . " ORDER BY title";

        //$risposta = mysqli_query($connection, $sql) or 
        //        die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        //mysqli_close($connection);

        //$books = array();
        //while ($riga = mysqli_fetch_array($risposta)) {
        //    $author = $this->findAuthorById($riga['author_id']);
        //    $books[] = new Book($riga['id'], $riga['title'], 
        //            $author->getLastName(), 
        //            $riga['author_id'], $riga['user_id']);
        //}
        
        $books = Book::where('user_id',$user)->orderBy('title','asc')->get();
        return $books;
    }
    
    public function listAuthors($user) {
        
        //$connection = $this->db_connect();

        //$sql = "SELECT * FROM author WHERE user_id = " . $user 
        //        . " ORDER BY lastname,firstname";

        //$risposta = mysqli_query($connection, $sql) or 
        //        die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        //mysqli_close($connection);

        //$authors = array();
        //while ($riga = mysqli_fetch_array($risposta)) {
        //    $authors[] = new Author($riga['id'], $riga['firstname'], 
        //            $riga['lastname'], $riga['user_id']);
        //}
        
        $authors = Author::where('user_id',$user)->orderBy('lastname','asc')
                ->orderBy('firstname','asc')->get();
        return $authors;
    }
    
    public function findAuthorById($id) {
        //$connection = $this->db_connect();
        //$sql = "SELECT * FROM author where id='" . $id . "'";
        //$risposta = mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());
        //mysqli_close($connection);

        //$riga = mysqli_fetch_array($risposta);

        //return new Author($riga['id'], $riga['firstname'], $riga['lastname'], $riga['user_id']);
        
        return Author::find($id);
    }

    public function deleteAuthor($id) {
        //$connection = $this->db_connect();
        //$sql = "DELETE FROM author where id='" . $id . "'";
        //mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        //mysqli_close($connection);
        
        Author::find($id)->delete(); // Author::destroy($id);
    }

    public function editAuthor($id, $first_name, $last_name) {
        //$connection = $this->db_connect();
        //$sql = "UPDATE author SET firstname='" . $first_name . "', lastname='" . $last_name . "' WHERE id=" . $id;
        //mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        //mysqli_close($connection);
        
        $author = Author::find($id);
        $author->firstname = $first_name;
        $author->lastname = $last_name;
        $author->save();
        // massive update (only with fillable property enabled on Author): 
        // Author::find($id)->update(['firstname' => $first_name, 'lastname' => $last_name]);
    }

    public function addAuthor($first_name, $last_name, $user) {
        //$connection = $this->db_connect();
        //$sql = "INSERT INTO author (firstname,lastname,user_id) "
        //. "VALUES ('" . $first_name . "','" . $last_name . "','" . $user . "')";
        //mysqli_query($connection, $sql) or 
        //        die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        //mysqli_close($connection);
        
        $author = new Author;
        $author->firstname = $first_name;
        $author->lastname = $last_name;
        $author->user_id = $user;
        $author->save();
        // massive creation (only with fillable property enabled on Author):
        // Author::create(['firstname' => $first_name, 'lastname' => $last_name, 'user_id' => $user]);
    }

    public function findBookById($id) {
        return Book::find($id);
    }

    public function deleteBook($id) {
        Book::find($id)->delete();
    }

    public function editBook($id, $title, $author_id) {
        $book = Book::find($id);
        $book->title = $title;
        $book->author_id = $author_id;
        $book->save();
        // massive update (only with fillable property enabled on Book): 
        // Book::find($id)->update(['title' => $title, 'author_id' => $author_id]);
    }

    public function addBook($title, $author_id, $user) {
        $book = new Book;
        $book->title = $title;
        $book->author_id = $author_id;
        $book->user_id = $user;
        $book->save();
        // massive creation (only with fillable property enabled on Book):
        // Book::create(['title' => $title, 'author_id' => $author_id, 'user_id' => $user]);
    }

    public function findBooksByAuthorID($author_id) {
        //$connection = $this->db_connect();
        //$sql = "SELECT * FROM book where author_id='" . $author_id . "'";
        //$risposta = mysqli_query($connection, $sql) or die('Errore nella query: ' . $sql . '\n' . mysqli_error());

        //if (mysqli_affected_rows($connection) != 0) {
        //    mysqli_close($connection);
        //    return true;
        //} else {
        //    mysqli_close($connection);
        //    return false;
        //}
        
        $books = Book::where('author_id',$author_id)->get();
        if(count($books) != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function validUser($username, $password) {
        $users = LibUser::where('username',$username)->get(['password']);
        
        if(count($users) == 0)
        {
            return false;
        }
        
        return (md5($password) == ($users[0]->password));
    }
    
    public function addUser($username, $password, $email) {
        $user = new LibUser();
        $user->username = $username;
        $user->password = md5($password);
        $user->email = $email;
        $user->save();
        // massive creation (only with fillable property enabled on LibUser):
        // LibUser::create(['username' => $username, 'password' => md5($password), 'email' => $email]);
    }
    
    public function getUserID($username) {
        $users = LibUser::where('username',$username)->get(['id']);
        return $users[0]->id;
    }
}

