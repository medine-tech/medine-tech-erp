import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import { LandingPage } from "./LandingPage";

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<LandingPage />} />
        {/* Aquí puedes agregar más rutas según sea necesario */}
        {/* <Route path="/login" element={<Login />} /> */}
        {/* <Route path="/register" element={<Register />} /> */}
      </Routes>
    </Router>
  );
}

export default App;
