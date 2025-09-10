<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Daftar data dummy untuk diacak
        $jabatan = ['Ahli Pertama - Perencana', 'Ahli Muda - Analis', 'Ahli Madya - Statistisi', 'Ahli Utama - Peneliti'];
        $instansi = ['Kementerian Keuangan', 'Badan Pusat Statistik', 'Kementerian PPN/Bappenas', 'Lembaga Ilmu Pengetahuan Indonesia'];

        return [
            'nama_lengkap' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            
            'nip' => $this->faker->unique()->numerify('199#########202#####'),
            'gol_ruang' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'no_telp' => $this->faker->phoneNumber(),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'tanggal_lahir' => $this->faker->date(),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
            'npwp' => $this->faker->numerify('##.###.###.#-###.###'),
            'asal_instansi' => $this->faker->randomElement($instansi),
            'unit_kerja' => 'Biro Perencanaan',
            'jabatan_fungsional' => $this->faker->randomElement($jabatan),
            'pas_foto' => null,
            'level' => 'anggota',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}