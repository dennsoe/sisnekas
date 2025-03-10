<?php

namespace App\Data;

class GelarAkademikData
{
    public static function getGelarAkademik(): array
    {
        return [
            'Diploma' => [
                'A.Ma.' => 'A.Ma. (Ahli Madya)',
                'A.Ma.P.' => 'A.Ma.P. (Ahli Madya Pendidikan)',
                'A.Ma.Pd.' => 'A.Ma.Pd. (Ahli Madya Pendidikan)',
                'A.Ma.PK.' => 'A.Ma.PK. (Ahli Madya Perpustakaan)',
                'A.Md.' => 'A.Md. (Ahli Madya)',
                'A.Md.A.K.K.' => 'A.Md.A.K.K. (Ahli Madya Analisis Kesehatan)',
                'A.Md.Farm.' => 'A.Md.Farm. (Ahli Madya Farmasi)',
                'A.Md.Ft.' => 'A.Md.Ft. (Ahli Madya Fisioterapi)',
                'A.Md.Gz.' => 'A.Md.Gz. (Ahli Madya Gizi)',
                'A.Md.Keb.' => 'A.Md.Keb. (Ahli Madya Kebidanan)',
                'A.Md.Kel.' => 'A.Md.Kel. (Ahli Madya Keperawatan Lanjutan)',
                'A.Md.Kep.' => 'A.Md.Kep. (Ahli Madya Keperawatan)',
                'A.Md.Kom.' => 'A.Md.Kom. (Ahli Madya Komputer)',
                'A.Md.Log.' => 'A.Md.Log. (Ahli Madya Logistik)',
                'A.Md.OT.' => 'A.Md.OT. (Ahli Madya Okupasi Terapi)',
                'A.Md.Par.' => 'A.Md.Par. (Ahli Madya Pariwisata)',
                'A.Md.Pel.' => 'A.Md.Pel. (Ahli Madya Pelayaran)',
                'A.Md.Per.' => 'A.Md.Per. (Ahli Madya Perikanan)',
                'A.Md.Rad.' => 'A.Md.Rad. (Ahli Madya Radiologi)',
                'A.Md.T.' => 'A.Md.T. (Ahli Madya Teknik)',
                'A.Md.TW.' => 'A.Md.TW. (Ahli Madya Teknik Wicara)',
                'A.P.' => 'A.P. (Ahli Pertanian)',
            ],

            'Sarjana (S1)' => [
                'S.Ag.' => 'S.Ag. (Sarjana Agama)',
                'S.Ak.' => 'S.Ak. (Sarjana Akuntansi)',
                'S.An.' => 'S.An. (Sarjana Antropologi)',
                'S.Ant.' => 'S.Ant. (Sarjana Antropologi)',
                'S.Ap.' => 'S.Ap. (Sarjana Administrasi Pemerintahan)',
                'S.Arch.' => 'S.Arch. (Sarjana Arsitektur)',
                'S.Ds.' => 'S.Ds. (Sarjana Desain)',
                'S.E.' => 'S.E. (Sarjana Ekonomi)',
                'S.Farm.' => 'S.Farm. (Sarjana Farmasi)',
                'S.Gz.' => 'S.Gz. (Sarjana Gizi)',
                'S.H.' => 'S.H. (Sarjana Hukum)',
                'S.H.I.' => 'S.H.I. (Sarjana Hukum Islam)',
                'S.Hum.' => 'S.Hum. (Sarjana Humaniora)',
                'S.I.A.' => 'S.I.A. (Sarjana Ilmu Administrasi)',
                'S.I.K.' => 'S.I.K. (Sarjana Ilmu Kepolisian)',
                'S.I.Kom.' => 'S.I.Kom. (Sarjana Ilmu Komunikasi)',
                'S.I.P.' => 'S.I.P. (Sarjana Ilmu Politik)',
                'S.K.G.' => 'S.K.G. (Sarjana Kedokteran Gigi)',
                'S.K.H.' => 'S.K.H. (Sarjana Kedokteran Hewan)',
                'S.K.M.' => 'S.K.M. (Sarjana Kesehatan Masyarakat)',
                'S.Keb.' => 'S.Keb. (Sarjana Kebidanan)',
                'S.Ked.' => 'S.Ked. (Sarjana Kedokteran)',
                'S.Kep.' => 'S.Kep. (Sarjana Keperawatan)',
                'S.Kes.' => 'S.Kes. (Sarjana Kesehatan)',
                'S.Kg.' => 'S.Kg. (Sarjana Keperawatan Gigi)',
                'S.Kom.' => 'S.Kom. (Sarjana Komputer)',
                'S.KM.' => 'S.KM. (Sarjana Kesehatan Masyarakat)',
                'S.Mat.' => 'S.Mat. (Sarjana Matematika)',
                'S.Or.' => 'S.Or. (Sarjana Olahraga)',
                'S.P.' => 'S.P. (Sarjana Pertanian)',
                'S.Pd.' => 'S.Pd. (Sarjana Pendidikan)',
                'S.Pd.I.' => 'S.Pd.I. (Sarjana Pendidikan Islam)',
                'S.Pd.K.' => 'S.Pd.K. (Sarjana Pendidikan Kristen)',
                'S.Pi.' => 'S.Pi. (Sarjana Perikanan)',
                'S.Psi.' => 'S.Psi. (Sarjana Psikologi)',
                'S.Pt.' => 'S.Pt. (Sarjana Peternakan)',
                'S.Si.' => 'S.Si. (Sarjana Sains)',
                'S.Sn.' => 'S.Sn. (Sarjana Seni)',
                'S.Sos.' => 'S.Sos. (Sarjana Sosial)',
                'S.S.' => 'S.S. (Sarjana Sastra)',
                'S.ST.' => 'S.ST. (Sarjana Sains Terapan)',
                'S.Sta.' => 'S.Sta. (Sarjana Statistika)',
                'S.T.' => 'S.T. (Sarjana Teknik)',
                'S.Th.' => 'S.Th. (Sarjana Theologi)',
                'S.Tr.Ak.' => 'S.Tr.Ak. (Sarjana Terapan Akuntansi)',
                'S.Tr.Keb.' => 'S.Tr.Keb. (Sarjana Terapan Kebidanan)',
                'S.Tr.T.' => 'S.Tr.T. (Sarjana Terapan Teknik)',
            ],

            'Magister (S2)' => [
                'M.A.' => 'M.A. (Master of Arts)',
                'M.Ag.' => 'M.Ag. (Magister Agama)',
                'M.Ak.' => 'M.Ak. (Magister Akuntansi)',
                'M.Arch.' => 'M.Arch. (Magister Arsitektur)',
                'M.B.A.' => 'M.B.A. (Master of Business Administration)',
                'M.Biotech.' => 'M.Biotech. (Magister Bioteknologi)',
                'M.Eng.' => 'M.Eng. (Master of Engineering)',
                'M.Farm.' => 'M.Farm. (Magister Farmasi)',
                'M.H.' => 'M.H. (Magister Hukum)',
                'M.Han.' => 'M.Han. (Magister Pertahanan)',
                'M.Hum.' => 'M.Hum. (Magister Humaniora)',
                'M.I.Kom.' => 'M.I.Kom. (Magister Ilmu Komunikasi)',
                'M.I.P.' => 'M.I.P. (Magister Ilmu Politik)',
                'M.Kes.' => 'M.Kes. (Magister Kesehatan)',
                'M.Keb.' => 'M.Keb. (Magister Kebidanan)',
                'M.Ked.' => 'M.Ked. (Magister Kedokteran)',
                'M.Kom.' => 'M.Kom. (Magister Komputer)',
                'M.M.' => 'M.M. (Magister Manajemen)',
                'M.Mat.' => 'M.Mat. (Magister Matematika)',
                'M.Min.' => 'M.Min. (Magister Ministry)',
                'M.P.' => 'M.P. (Magister Pertanian)',
                'M.PA.' => 'M.PA. (Master of Public Administration)',
                'M.Pd.' => 'M.Pd. (Magister Pendidikan)',
                'M.Phil.' => 'M.Phil. (Master of Philosophy)',
                'M.Psi.' => 'M.Psi. (Magister Psikologi)',
                'M.PWK.' => 'M.PWK. (Magister Perencanaan Wilayah dan Kota)',
                'M.S.' => 'M.S. (Master of Science)',
                'M.Si.' => 'M.Si. (Magister Sains)',
                'M.Sn.' => 'M.Sn. (Magister Seni)',
                'M.Sc.' => 'M.Sc. (Master of Science)',
                'M.ST.' => 'M.ST. (Magister Sains Terapan)',
                'M.Stat.' => 'M.Stat. (Magister Statistika)',
                'M.Sy.' => 'M.Sy. (Magister Syariah)',
                'M.T.' => 'M.T. (Magister Teknik)',
                'M.Th.' => 'M.Th. (Magister Theologi)',
                'M.Tr.T.' => 'M.Tr.T. (Magister Terapan Teknik)',
            ],

            'Doktor (S3)' => [
                'Dr.' => 'Dr. (Doktor)',
                'D.Sc.' => 'D.Sc. (Doctor of Science)',
                'Ph.D.' => 'Ph.D. (Doctor of Philosophy)',
                'Dr.Eng.' => 'Dr.Eng. (Doctor of Engineering)',
                'Dr.P.H.' => 'Dr.P.H. (Doctor of Public Health)',
                'Dr.Rer.Nat.' => 'Dr.Rer.Nat. (Doctor Rerum Naturalium)',
                'Dr.Agr.' => 'Dr.Agr. (Doctor of Agriculture)',
            ],

            'Profesi' => [
                'Ak.' => 'Ak. (Akuntan)',
                'Apt.' => 'Apt. (Apoteker)',
                'Arsk.' => 'Arsk. (Arsitek)',
                'AAIJ.' => 'AAIJ. (Ahli Asuransi Indonesia)',
                'AAAIJ.' => 'AAAIJ. (Ajun Ahli Asuransi Indonesia)',
                'CPA.' => 'CPA. (Certified Public Accountant)',
                'dr.' => 'dr. (Dokter)',
                'drg.' => 'drg. (Dokter Gigi)',
                'Drs.' => 'Drs. (Doktorandus)',
                'Dra.' => 'Dra. (Doktoranda)',
                'Ir.' => 'Ir. (Insinyur)',
                'Ns.' => 'Ns. (Ners)',
                'Psi.' => 'Psi. (Psikolog)',
                'R.O.' => 'R.O. (Refraksionis Optisien)',
                'S.E.Ak.' => 'S.E.Ak. (Sarjana Ekonomi Akuntan)',
                'Sp.An.' => 'Sp.An. (Spesialis Anestesiologi)',
                'Sp.B.' => 'Sp.B. (Spesialis Bedah)',
                'Sp.JP.' => 'Sp.JP. (Spesialis Jantung dan Pembuluh Darah)',
                'Sp.M.' => 'Sp.M. (Spesialis Mata)',
                'Sp.OG.' => 'Sp.OG. (Spesialis Obstetri dan Ginekologi)',
                'Sp.PD.' => 'Sp.PD. (Spesialis Penyakit Dalam)',
                'Sp.THT-KL.' => 'Sp.THT-KL. (Spesialis Telinga Hidung Tenggorok)',
            ],
        ];
    }
}
