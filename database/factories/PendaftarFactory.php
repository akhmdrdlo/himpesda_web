<?php

namespace Database\Factories;

use App\Models\Pendaftar;
use Illuminate\Database\Eloquent\Factories\Factory;

class PendaftarFactory extends Factory
{
    protected $model = Pendaftar::class;

    public function definition()
    {
        return [
            'nama_lengkap' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'nip' => $this->faker->numerify('##########'),
            'gol_ruang' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'no_telp' => $this->faker->phoneNumber,
            'password' => 'password', // Password default, akan di-hash di model
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'tanggal_lahir' => $this->faker->date(),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'npwp' => $this->faker->numerify('##.###.###.#-###.###'),
            'asal_instansi' => $this->faker->company,
            'unit_kerja' => $this->faker->companySuffix,
            'jabatan_fungsional' => $this->faker->jobTitle,
            'pas_foto' => 'pas_foto_' . $this->faker->unique()->numberBetween(1, 1000) . '.jpg',
            'bukti_pembayaran' => 'bukti_' . $this->faker->unique()->numberBetween(1, 1000) . '.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
