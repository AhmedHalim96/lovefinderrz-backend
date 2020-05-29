<?php

use App\User;
use Illuminate\Database\Seeder;

class SeedUserTable extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    $user1 = new User();
    $user1->name = 'Ahmed Halim';
    $user1->avatar = 'hello';
    $user1->email = 'ahmedh@email.com';
    $user1->password = \Hash::make('secret');
    $user1->save();

    $user2 = new User();
    $user2->name = 'Ahmed Samy';
    $user2->avatar = 'hello';
    $user2->email = 'ahmeds@email.com';
    $user2->password = \Hash::make('secret');
    $user2->save();
  }
}