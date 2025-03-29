import { AuthProvider } from "./sections/auth/context/AuthContext";
import { RouterWithAuth } from "./sections/shared/router";

function App() {
  return (
    <AuthProvider>
      <RouterWithAuth />
    </AuthProvider>
  );
}

export default App;
