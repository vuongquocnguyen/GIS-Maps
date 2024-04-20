function danhsachtuyenbus(){
	alert("OK");
}
this.datum = {};
    this.datum.ellipsoid = {
        a: 6378137,
        b: 6356752.3142,
        f: 1 / 298.257223563
      }; // WGS-84
function distance(p1, p2) {
    var φ1 = p1.lat.toRadians(),
      λ1 = p1.lng.toRadians();
    var φ2 = p2.lat.toRadians(),
      λ2 = p2.lng.toRadians();

    var a = this.datum.ellipsoid.a,
      b = this.datum.ellipsoid.b,
      f = this.datum.ellipsoid.f;

    var L = λ2 - λ1;
    var tanU1 = (1 - f) * Math.tan(φ1),
      cosU1 = 1 / Math.sqrt((1 + tanU1 * tanU1)),
      sinU1 = tanU1 * cosU1;
    var tanU2 = (1 - f) * Math.tan(φ2),
      cosU2 = 1 / Math.sqrt((1 + tanU2 * tanU2)),
      sinU2 = tanU2 * cosU2;

    var λ = L,
      λʹ, iterations = 0;
    var cosSqα, sinσ, cos2σM, cosσ, σ, sinλ, cosλ;
    do {
      sinλ = Math.sin(λ);
      cosλ = Math.cos(λ);
      var sinSqσ = (cosU2 * sinλ) * (cosU2 * sinλ) + (cosU1 * sinU2 -
        sinU1 * cosU2 * cosλ) * (cosU1 * sinU2 - sinU1 * cosU2 * cosλ);
      sinσ = Math.sqrt(sinSqσ);
      if (sinσ == 0) return 0; // co-incident points
      cosσ = sinU1 * sinU2 + cosU1 * cosU2 * cosλ;
      σ = Math.atan2(sinσ, cosσ);
      var sinα = cosU1 * cosU2 * sinλ / sinσ;
      cosSqα = 1 - sinα * sinα;
      cos2σM = cosσ - 2 * sinU1 * sinU2 / cosSqα;
      if (isNaN(cos2σM)) cos2σM = 0; // equatorial line: cosSqα=0 (§6)
      var C = f / 16 * cosSqα * (4 + f * (4 - 3 * cosSqα));
      λʹ = λ;
      λ = L + (1 - C) * f * sinα * (σ + C * sinσ * (cos2σM + C * cosσ * (-
        1 + 2 * cos2σM * cos2σM)));
    } while (Math.abs(λ - λʹ) > 1e-12 && ++iterations < 100);
    if (iterations >= 100) {
      console.log("Formula failed to converge. Altering target position.");
      return this._vincenty_inverse(p1, {
          lat: p2.lat,
          lng: p2.lng - 0.01
        });
        //  throw new Error('Formula failed to converge');
    }

    var uSq = cosSqα * (a * a - b * b) / (b * b);
    var A = 1 + uSq / 16384 * (4096 + uSq * (-768 + uSq * (320 - 175 *
      uSq)));
    var B = uSq / 1024 * (256 + uSq * (-128 + uSq * (74 - 47 * uSq)));
    var Δσ = B * sinσ * (cos2σM + B / 4 * (cosσ * (-1 + 2 * cos2σM *
        cos2σM) -
      B / 6 * cos2σM * (-3 + 4 * sinσ * sinσ) * (-3 + 4 * cos2σM *
        cos2σM)));

    var s = b * A * (σ - Δσ);

    var fwdAz = Math.atan2(cosU2 * sinλ, cosU1 * sinU2 - sinU1 * cosU2 *
      cosλ);
    var revAz = Math.atan2(cosU1 * sinλ, -sinU1 * cosU2 + cosU1 * sinU2 *
      cosλ);

    s = Number(s.toFixed(3)); // round to 1mm precision
    return {
      distance: s,
      initialBearing: fwdAz.toDegrees(),
      finalBearing: revAz.toDegrees()
    };
  }