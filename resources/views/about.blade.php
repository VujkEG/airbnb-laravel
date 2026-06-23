@extends('layouts.app')

@section('content')
<!-- Hero Sekcija -->
<div style="background: linear-gradient(135deg, #1a1a2e 0%, #161623 100%); color: white; padding: 80px 0; text-align: center; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255, 56, 92, 0.1); border-radius: 50%; filter: blur(50px);"></div>
    <div style="position: absolute; bottom: -50px; left: -50px; width: 250px; height: 250px; background: rgba(15, 52, 96, 0.4); border-radius: 50%; filter: blur(60px);"></div>
    
    <div class="container" style="position: relative; z-index: 2;">
        <span style="color: #ff385c; text-transform: uppercase; letter-spacing: 2px; font-size: 0.85rem; font-weight: 700; display: block; margin-bottom: 10px;">Upoznajte našu priču</span>
        <h1 style="font-size: 3rem; font-weight: 800; margin-bottom: 15px; letter-spacing: -1px;">O Nama</h1>
        <p style="color: #94a3b8; font-size: 1.1rem; max-width: 600px; margin: 0 auto; line-height: 1.6;">
            Povezujemo ljude sa prelepim prostorima i stvaramo nezaboravna iskustva putovanja širom sveta.
        </p>
    </div>
</div>

<!-- Glavni sadržaj sa brojačima (Grid Layout) -->
<div class="container py-5" style="font-family: 'Segoe UI', Arial, sans-serif; max-width: 1140px;">
    <div style="display: flex; flex-wrap: wrap; gap: 40px; align-items: center; margin-bottom: 60px;">
        <!-- Tekstualni deo -->
        <div style="flex: 1 1 500px;">
            <h2 style="font-size: 2rem; font-weight: 700; color: #1a1a2e; margin-bottom: 20px; position: relative;">
                Ko smo mi?
                <span style="display: block; width: 50px; height: 4px; background: #ff385c; margin-top: 8px; border-radius: 2px;"></span>
            </h2>
            <p style="line-height: 1.7; color: #4a5568; font-size: 1.05rem; margin-bottom: 20px;">
                Dobrodošli na <strong>Aveniju Smeštaj</strong>, vašeg pouzdanog partnera u pronalaženju idealnog kutka za odmor, poslovni put ili vikend beg. Naša platforma je stvorena sa vizijom da proces rezervacije učini maksimalno brzim, transparentnim i prijatnim.
            </p>
            <p style="line-height: 1.7; color: #4a5568; font-size: 1.05rem;">
                Bilo da tražite moderan apartman u samom centru grada, planinsku brvnaru sa SPA zonom ili tihu kućicu na obali mora – tu smo da vam obezbedimo vrhunski komfor i sigurnost.
            </p>
        </div>

        <!-- Statistika / Brojači -->
        <div style="flex: 1 1 400px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid #eef0f2; text-align: center;">
                <h3 style="font-size: 2.2rem; font-weight: 800; color: #ff385c; margin-bottom: 5px;">500+</h3>
                <p style="color: #718096; margin: 0; font-weight: 500; font-size: 0.95rem;">Aktivnih smeštaja</p>
            </div>
            <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid #eef0f2; text-align: center;">
                <h3 style="font-size: 2.2rem; font-weight: 800; color: #1a1a2e; margin-bottom: 5px;">12k+</h3>
                <p style="color: #718096; margin: 0; font-weight: 500; font-size: 0.95rem;">Zadovoljnih gostiju</p>
            </div>
            <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid #eef0f2; text-align: center;">
                <h3 style="font-size: 2.2rem; font-weight: 800; color: #1a1a2e; margin-bottom: 5px;">4.9</h3>
                <p style="color: #718096; margin: 0; font-weight: 500; font-size: 0.95rem;">Prosečna ocena</p>
            </div>
            <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid #eef0f2; text-align: center;">
                <h3 style="font-size: 2.2rem; font-weight: 800; color: #ff385c; margin-bottom: 5px;">24/7</h3>
                <p style="color: #718096; margin: 0; font-weight: 500; font-size: 0.95rem;">Korisnička podrška</p>
            </div>
        </div>
    </div>

    <!-- Naše Vrednosti -->
    <div style="margin-top: 80px; text-align: center;">
        <h2 style="font-size: 1.8rem; font-weight: 700; color: #1a1a2e; margin-bottom: 40px;">Vrednosti iza kojih stojimo</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
            <!-- Kartica 1 -->
            <div style="background: white; padding: 35px 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid #eef0f2; text-align: left;">
                <div style="width: 50px; height: 50px; background: rgba(255, 56, 92, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                    <!-- Štit SVG (Sigurnost) -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ff385c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h4 style="font-size: 1.2rem; font-weight: 600; color: #1a1a2e; margin-bottom: 10px;">100% Sigurnost</h4>
                <p style="color: #718096; line-height: 1.6; margin: 0; font-size: 0.95rem;">Svaka rezervacija i domaćin prolaze kroz naš sistem verifikacije kako biste spavali potpuno bezbrižno.</p>
            </div>

            <!-- Kartica 2 -->
            <div style="background: white; padding: 35px 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid #eef0f2; text-align: left;">
                <div style="width: 50px; height: 50px; background: rgba(26, 26, 46, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                    <!-- Zvezda SVG (Kvalitet) -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1a1a2e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
                <h4 style="font-size: 1.2rem; font-weight: 600; color: #1a1a2e; margin-bottom: 10px;">Vrhunski Kvalitet</h4>
                <p style="color: #718096; line-height: 1.6; margin: 0; font-size: 0.95rem;">Biramo samo najbolje ocenjene smeštaje koji ispunjavaju visoke standarde čistoće i gostoprimstva.</p>
            </div>

            <!-- Kartica 3 -->
            <div style="background: white; padding: 35px 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); border: 1px solid #eef0f2; text-align: left;">
                <div style="width: 50px; height: 50px; background: rgba(255, 56, 92, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                    <!-- Strelica/Osvežavanje SVG (Fleksibilnost) -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ff385c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
                </div>
                <h4 style="font-size: 1.2rem; font-weight: 600; color: #1a1a2e; margin-bottom: 10px;">Fleksibilnost</h4>
                <p style="color: #718096; line-height: 1.6; margin: 0; font-size: 0.95rem;">Razumemo da se planovi menjaju. Zato nudimo opcije lake i brze promene ili otkazivanja termina.</p>
            </div>
        </div>
    </div>
</div>
@endsection