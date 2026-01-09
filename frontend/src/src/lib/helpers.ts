import type { Ref } from "vue";

export function previousDay(date: Date) {
  return new Date(date.getTime() - 24 * 60 * 60 * 1000);
}

export function nextDay(date: Date) {
  return new Date(date.getTime() + 24 * 60 * 60 * 1000);
}
export function colorString(color: string, opacity: number) {
  return (
    "background-color: #" +
    color.padStart(6, "0") +
    opacity.toString(16).padStart(2, "0") +
    ";"
  );
}