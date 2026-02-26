(function () {
  "use strict";

  let activityLog = [];
  let idleTimer;
  let idleStart;
  const entryTime = new Date().toISOString();

  function getSessionId() {
    let sessionID = sessionStorage.getItem("cse135_session_id");
    if (!sessionID) {
      sessionID =
        "session-" + Math.random().toString(36).slice(2, 11) + "-" + Date.now();
      sessionStorage.setItem("cse135_session_id", sessionID);
    }
    return sessionID;
  }

  function getFeatureDetection() {
    const testEl = document.createElement("div");
    testEl.id = "css-test";
    testEl.style.display = "none";
    document.body.appendChild(testEl);
    const cssAllowed = window.getComputedStyle(testEl).display === "none";
    document.body.removeChild(testEl);

    let imagesAllowed = true;
    const img = new Image();
    img.src =
      "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";
    img.onerror = () => {
      imagesAllowed = false;
    };

    return {
      jsAllowed: true,
      cssAllowed,
      imagesAllowed,
    };
  }

  function getStaticAndPerf() {
    const navEntries = performance.getEntriesByType("navigation");
    const navEntry = navEntries.length > 0 ? navEntries[0] : null;

    const perf = navEntry || window.performance.timing;

    return {
      type: "static_and_performance",
      userEntered: entryTime,
      static: {
        userAgent: navigator.userAgent,
        language: navigator.language,
        cookies: navigator.cookieEnabled,
        features: getFeatureDetection(),
        screen: { w: screen.width, h: screen.height },
        window: { w: window.innerWidth, h: window.innerHeight },
        connection: navigator.connection
          ? navigator.connection.effectiveType
          : "unknown",
      },
      performance: {
        timingObject: perf,
        start: navEntry ? navEntry.startTime : perf.navigationStart,
        end: navEntry ? navEntry.loadEventEnd : perf.loadEventEnd,
        totalLoadTime: navEntry
          ? navEntry.duration
          : perf.loadEventEnd - perf.navigationStart,
      },
    };
  }

  function logActivity(type, details) {
    activityLog.push({
      type: type,
      timestamp: new Date().toISOString(),
      page: window.location.pathname,
      details: details,
    });
    resetIdleTimer();
  }

  function resetIdleTimer() {
    if (idleStart) {
      const duration = Date.now() - idleStart;
      if (duration >= 2000) {
        logActivity("idle_end", { durationMs: duration });
      }
      idleStart = null;
    }
    clearTimeout(idleTimer);
    idleTimer = setTimeout(() => {
      idleStart = Date.now();
    }, 2000);
  }

  window.addEventListener("mousemove", (e) =>
    logActivity("mousemove", { x: e.clientX, y: e.clientY }),
  );
  window.addEventListener("click", (e) =>
    logActivity("click", { button: e.button, x: e.clientX, y: e.clientY }),
  );
  window.addEventListener("keydown", (e) =>
    logActivity("keydown", { key: e.key }),
  );
  window.addEventListener("scroll", () =>
    logActivity("scroll", { x: window.scrollX, y: window.scrollY }),
  );

  window.onerror = (msg, url, line) => logActivity("error", { msg, url, line });

  function transmit(type) {
    const endpoint = "https://collector.kylacse135.site/collect.php";
    const payload = {
      sessionId: getSessionId(),
      type: type,
      exitTime: type === "activity" ? new Date().toISOString() : null,
      date: type === "initial" ? getStaticAndPerf() : activityLog,
    };

    const blob = new Blob([JSON.stringify(payload)], {
      type: "application/json",
    });

    if (navigator.sendBeacon) {
      navigator.sendBeacon(endpoint, blob);
    } else {
      fetch(endpoint, { method: "POST", body: blob, keepalive: true });
    }

    if (type === "activity") {
      activityLog = [];
    }
  }

  window.addEventListener("load", () => {
    setTimeout(() => transmit("initial"), 100);
  });

  window.addEventListener("visibilitychange", () => {
    if (document.visibilityState === "hidden") {
      logActivity("exit", {
        url: window.location.href,
        time: new Date().toISOString(),
      });
      transmit("activity");
    }
  });
});
