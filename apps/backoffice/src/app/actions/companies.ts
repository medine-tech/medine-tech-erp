"use server";

import { getAuthToken } from "@/app/actions/auth";

type FetchCompanies = Promise<any>;

export async function getCompanies(): FetchCompanies {
  try {
    const response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/companies`, {
      method: "GET",
      headers: {
        accept: "application/json",
        "Content-Type": "application/json",
        Authorization: `Bearer ${await getAuthToken()}`,
      },
    });
    if (!response.ok) {
      throw new Error("Error fetching companies");
    }

    return await response.json();
  } catch (error) {
    const errorMessage = error instanceof Error ? error.message : "An unexpected error occurred";

    return {
      status: 500,
      message: errorMessage,
      data: { data: [] },
    };
  }
}
